<?php

namespace App\Services;

use App\Models\Charge;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\Transformers\Facades\MeteringPointTransformer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tvup\ElOverblikApi\ElOverblikApiException;
use Tvup\ElOverblikApi\ElOverblikApiInterface;
use Tvup\EwiiApi\EwiiApiException;
use Tvup\EwiiApi\EwiiApiInterface;

class GetMeteringData
{
    private ElOverblikApiInterface|null $energiOverblikApi = null;

    private EwiiApiInterface|null $ewiiApi;

    public function __construct()
    {
    }

    /**
     * @param string $start_date
     * @param string $end_date
     * @param string $refreshToken
     * @param bool $debug
     * @return array<string, string>
     * @throws ElOverblikApiException
     */
    public function getData(string $start_date, string $end_date, string $refreshToken, bool $debug = false): array
    {
        logger('Accessing EloverblikApi. MD5 of refresh token: ' . md5($refreshToken));
        $energiOverblikApi = $this->getEloverblikApi($refreshToken);

        if ($debug) {
            $energiOverblikApi->setDebug(true);
        }

        $meteringPointId = $this->getMeteringPointData('DATAHUB', ['refresh_token' => $refreshToken])->metering_point_id;

        try {
            if (!$start_date) {
                $start_date = Carbon::now()->startOfMonth()->toDateString();
            }
            if (!$end_date) {
                $end_date = Carbon::now()->toDateString();
            }
            logger('Retrieving consumption data from eloverlikApi with parameters: Start date => ' . $start_date . ' End date => ' . $end_date . ' Metering point id => ' . $meteringPointId);
            $response = $energiOverblikApi->getHourTimeSeriesFromMeterData($start_date, Carbon::parse($end_date)->toDateString(), $meteringPointId);
        } catch (ElOverblikApiException $e) {
            logger()->warning('Retrieving consumption data from eloverlikApi was unsuccesful (' . $e->getCode() . ') with parameters: Start date => ' . $start_date . ' End date => ' . $end_date . ' Metering point id => ' . $meteringPointId);
            throw $e;
        }

        return $response;
    }

    public function getDataFromEwii(string $start_date = null, string $end_date = null, string $email = null, string $password = null): array
    {
        if (!$email || !$password) {
            $email = config('services.ewii.email');
            $password = config('services.ewii.password');
        }

        logger('Accessing EwiiApi.');

        $ewiiApi = $this->getEwiiApi($email, $password);

        try {
            if (!$start_date) {
                $start_date = Carbon::now()->startOfMonth()->toDateString();
            }
            if (!$end_date) {
                $end_date = Carbon::now()->toDateString();
            }
            logger('Retrieving consumption data from ewiiApi with parameters: Start date => ' . $start_date . ' End date => ' . $end_date);
            $ewiiApi->login($email, $password);
            $response = $ewiiApi->getAddressPickerViewModel();

            $ewiiApi->setSelectedAddressPickerElement($email == 'info@butikkenvedhojen.dk' ? $response[1] : $response[0]);
            $response = $ewiiApi->getConsumptionMeters();
            $response = $ewiiApi->getConsumptionData('csv', $response);
            foreach (array_keys($response) as $key) {
                if (Carbon::parse($key)->isBefore(Carbon::parse($start_date))) {
                    unset($response[$key]);
                }
                if (Carbon::parse($key)->isAfter(Carbon::parse($end_date))) {
                    unset($response[$key]);
                }
            }
        } catch (EwiiApiException $e) {
            logger()->error('Call to get consumption data from ewiiApi failed');
            throw $e;
        }

        return $response;
    }

    public function getMeteringPointData(string|null $source = null, array $credentials = [], User $user = null): MeteringPoint|null
    {
        $refresh_token = isset($credentials['refresh_token']) ? $credentials['refresh_token'] : null;
        $ewiiUserName = isset($credentials['ewii_user_name']) ? $credentials['ewii_user_name'] : null;
        $ewiiPassword = isset($credentials['ewii_password']) ? $credentials['ewii_password'] : null;
        $exception = null;
        switch ($source) {
            case 'DATAHUB':
                if (!$refresh_token) {
                    throw new \InvalidArgumentException('When retrieving data from Datahub, refresh token must be provided');
                }
                $key = 'meteringPointData ' . $refresh_token;
                $meteringPoint = $this->getMeteringPointFromCache($key);
                if ($meteringPoint) {
                    return MeteringPointTransformer::transform($meteringPoint, 'DATAHUB');
                }
                $energiOverblikApi = $this->getEloverblikApi($refresh_token);
                $response = null;
                try {
                    $response = $energiOverblikApi->getMeteringPointData();
                } catch (ElOverblikApiException $e) {
                    $exception = $e;
                }
                if ($response) {
                    $response['source'] = 'DATAHUB';
                    $expiresAt = now()->addDay()->startOfDay();
                    cache([$key => $response], $expiresAt);

                    return MeteringPointTransformer::transform($response, 'DATAHUB');
                }
            case 'EWII':
                if (!$ewiiUserName || !$ewiiPassword) {
                    if ($source == 'EWII') {
                        throw new \InvalidArgumentException('When retrieving data from EWII, username and password must be provided');
                    }
                } else {

                    $key = 'meteringPointData ' . $ewiiUserName;
                    $meteringPoint = $this->getMeteringPointFromCache($key);
                    if ($meteringPoint) {
                        return MeteringPointTransformer::transform($meteringPoint, 'EWII');
                    }
                    try {
                        $ewiiApi = $this->getEwiiApi($ewiiUserName, $ewiiPassword);
                        $ewiiApi->login($ewiiUserName, $ewiiPassword);
                        $response1 = $ewiiApi->getAddressPickerViewModel();
//                    $ewiiApi->setSelectedAddressPickerElement($response1);
//                    $response2 = $ewiiApi->getConsumptionMetersRaw();
//                    $responseCombined = array_merge($response1, $response2);

                        if ($response1) {
                            $expiresAt = now()->addDay()->startOfDay();
                            cache([$key => $response1], $expiresAt);

                            return MeteringPointTransformer::transform($response1, 'EWII');
                        }
                    } catch (EwiiApiException $e) {
                        if (!$exception) {
                            $exception = $e;
                        }
                    }
                }

            case 'POWERUSE':
            default:
                if (!$user) {
                    if ($source == 'POWERUSE') {
                        throw new \InvalidArgumentException('When retrieving data from POWERUSE, user must be provided');
                    } else {
                        break;
                    }
                }
                $meteringPoint = MeteringPoint::whereUserId($user->id)->first();

                if ($meteringPoint) {
                    return MeteringPointTransformer::transform($meteringPoint, 'POWERUSE');
                } else {
                    if (!$exception) {
                        /** @var ModelNotFoundException $myex */
                        $exception = app()->make(ModelNotFoundException::class)->setModel(MeteringPoint::class, ['where user_id is ' . $user->id]);
                    }
                }
        }

        if ($exception) {
            throw $exception;
        }

        return null;
    }

    public function getMeteringPointDataFromEwii(string $email = null, string $password = null): array
    {
        $key = 'meteringPointData ' . $email;

        $meteringPointData = cache($key);
        if ($meteringPointData) {
            return $meteringPointData;
        }

        if (!$email || !$password) {
            $email = config('services.ewii.email');
            $password = config('services.ewii.password');
        }

        try {
            $ewiiApi = $this->getEwiiApi($email, $password);

            $ewiiApi->login($email, $password);
            $response1 = $ewiiApi->getAddressPickerViewModel();
            $ewiiApi->setSelectedAddressPickerElement($response1);
            $response2 = $ewiiApi->getConsumptionMetersRaw();
            $responseCombined = array_merge($response1, $response2);
            $expiresAt = now()->addDay()->startOfDay();
            cache([$key => $responseCombined], $expiresAt);
        } catch (EwiiApiException $e) {
            throw $e;
        }

        return $responseCombined;
    }

    public function getCharges(string|null $source = 'DATAHUB', array $credentials = [], User $user = null): array
    {
        $refresh_token = isset($credentials['refresh_token']) ? $credentials['refresh_token'] : null;
        $meteringPoint = $this->getMeteringPointData($source, $credentials, $user);
        $meteringPointId = $meteringPoint->metering_point_id;

        $e = null;
        $subscriptions = collect();
        $tariffs = collect();

        //If no source is selected, we have a free choice
        //We'll start with Datahub in such case.
        $dataSource = null !== $source ? $source : 'DATAHUB';

        switch ($dataSource) {
            case 'DATAHUB':
                if($refresh_token) {
                    try {
                        $energiOverblikApi = $this->getEloverblikApi($refresh_token);
                        list($subscriptions, $tariffs) = $energiOverblikApi->getCharges($meteringPointId);
                    } catch (ElOverblikApiException $exception) {
                        if ($exception->getCode() == 503) {
                            logger()->error('Datahub not available for getCharges (503)');
                            $e = $exception;
                        }
                        logger()->error('Datahub returned error for getCharges for metering point ' . $meteringPointId);
                        $errors = $exception->getErrors();
                        switch (gettype($errors)) {
                            case 'array':
                                logger()->error('Got array of errors', [
                                    'errors' => $errors,
                                ]);
                                break;
                            case 'string':
                                logger()->error($errors);
                                break;
                            default:
                                logger()->error('Exception didn\'t return useful error messages either');
                        }
                        $e = $exception;
                    }
                    $fees = [];
                    if (count($subscriptions) > 0 && count($tariffs) > 0) {
                        return [$subscriptions, $tariffs, $fees];
                    }
                } else {
                    if ($source == 'DATAHUB') {
                        //DATAHUB was explicit chosen as provider, but refresh token isn't provided
                        throw new \InvalidArgumentException('When querying Datahub a refresh token must be provided');
                    }
                }
            case 'POWERUSE':
            default:
                $subscriptions = Charge::whereMeteringPointId($meteringPoint->id)->whereType('Abonnement')->get();
                $tariffs = Charge::whereMeteringPointId($meteringPoint->id)->whereType('Tarif')->get();
                $fees = Charge::whereMeteringPointId($meteringPoint->id)->whereType('Gebyr')->get();

                if ($subscriptions->count() > 0 && $tariffs->count() > 0) {
                    return [$subscriptions, $tariffs, $fees];
                }
                break;
        }
        if ($e) {
            throw $e;
        } else {
            return [[], [], []];
        }
    }

    private function getEloverblikApi(string $refreshToken): ElOverblikApiInterface
    {
        if (!$this->energiOverblikApi) {
            $energiOverblikApi = app()->make('Tvup\ElOverblikApi\ElOverblikApiInterface');
            $energiOverblikApi->token($refreshToken);
            $this->energiOverblikApi = $energiOverblikApi;
        }

        return $this->energiOverblikApi;
    }

    private function getEwiiApi(string $email = null, string $password = null): EwiiApiInterface
    {
        if (!property_exists('GetMeteringData', 'ewiiApi') || !$this->ewiiApi) {
            $this->ewiiApi = app()->makeWith('Tvup\EwiiApi\EwiiApiInterface', [
                'email' => $email,
                'password' => $password,
            ]);
        }

        return $this->ewiiApi;
    }

    private function getMeteringPointFromCache(string $key): array|null
    {
        return cache($key) ?? null;
    }
}
