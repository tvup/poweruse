<?php

namespace App\Services;

use App\Enums\SourceEnum;
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
    private ?ElOverblikApiInterface $energiOverblikApi = null;

    private ?EwiiApiInterface $ewiiApi;

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
        try {
            $energiOverblikApi = $this->getEloverblikApi($refreshToken);
        } catch (ElOverblikApiException $e) {
            if ($e->getCode() == 401) {
                logger()->warning('Refresh token is not authorized: ' . $refreshToken);
            }
            throw $e;
        }

        if ($debug) {
            $energiOverblikApi->setDebug(true);
        }

        $meteringPointId = $this->getMeteringPointData(SourceEnum::DATAHUB, ['refresh_token' => $refreshToken])->metering_point_id;

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

    public function getMeteringPointData(?SourceEnum $source = null, array $credentials = [], User $user = null): ? MeteringPoint
    {
        $refresh_token = isset($credentials['refresh_token']) ? $credentials['refresh_token'] : null;
        $ewiiUserName = isset($credentials['ewii_user_name']) ? $credentials['ewii_user_name'] : null;
        $ewiiPassword = isset($credentials['ewii_password']) ? $credentials['ewii_password'] : null;
        $exception = null;
        switch ($source) {
            case SourceEnum::DATAHUB:
                if (!$refresh_token) {
                    throw new \InvalidArgumentException('When retrieving data from Datahub, refresh token must be provided');
                }
                $key = 'meteringPointData ' . $refresh_token;
                $meteringPoint = $this->getMeteringPointFromCache($key);
                if ($meteringPoint) {
                    /** @var MeteringPoint $meteringPoint1 */
                    $meteringPoint1 = MeteringPointTransformer::transform($meteringPoint, SourceEnum::DATAHUB);

                    return $meteringPoint1;
                }
                $energiOverblikApi = $this->getEloverblikApi($refresh_token);
                $response = null;
                try {
                    $response = $energiOverblikApi->getMeteringPointData();
                } catch (ElOverblikApiException $e) {
                    $exception = $e;
                }
                if ($response) {
                    $response['source'] = SourceEnum::DATAHUB;
                    $expiresAt = now()->addDay()->startOfDay();
                    cache([$key => $response], $expiresAt);

                    /** @var MeteringPoint $meteringPoint5 */
                    $meteringPoint5 = MeteringPointTransformer::transform($response, SourceEnum::DATAHUB);

                    return $meteringPoint5;
                }
            case SourceEnum::EWII:
                if (!$ewiiUserName || !$ewiiPassword) {
                    if ($source == SourceEnum::EWII) {
                        throw new \InvalidArgumentException('When retrieving data from EWII, username and password must be provided');
                    }
                } else {
                    $key = 'meteringPointData ' . $ewiiUserName;
                    $meteringPoint = $this->getMeteringPointFromCache($key);
                    if ($meteringPoint) {
                        /** @var MeteringPoint $meteringPoint4 */
                        $meteringPoint4 = MeteringPointTransformer::transform($meteringPoint, SourceEnum::EWII);

                        return $meteringPoint4;
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

                            /** @var MeteringPoint $meteringPoint3 */
                            $meteringPoint3 = MeteringPointTransformer::transform($response1, SourceEnum::EWII);

                            return $meteringPoint3;
                        }
                    } catch (EwiiApiException $e) {
                        if (!$exception) {
                            $exception = $e;
                        }
                    }
                }

            case SourceEnum::POWERUSE:
            default:
                if (!$user) {
                    if ($source == SourceEnum::POWERUSE) {
                        throw new \InvalidArgumentException('When retrieving data from POWERUSE, user must be provided');
                    } else {
                        break;
                    }
                }
                $meteringPoint = MeteringPoint::whereUserId($user->id)->first();

                if ($meteringPoint) {
                    /** @var MeteringPoint $meteringPoint2 */
                    $meteringPoint2 = MeteringPointTransformer::transform($meteringPoint, SourceEnum::POWERUSE);

                    return $meteringPoint2;
                } else {
                    if (!$exception) {
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

    public function getCharges(?SourceEnum $source = SourceEnum::DATAHUB, array $credentials = [], User $user = null): array
    {
        $refresh_token = isset($credentials['refresh_token']) ? $credentials['refresh_token'] : null;
        $meteringPoint = $this->getMeteringPointData($source, $credentials, $user);
        $meteringPointId = $meteringPoint->metering_point_id;

        $e = null;
        $subscriptions = collect();
        $tariffs = collect();

        //If no source is selected, we have a free choice
        //We'll start with Datahub in such case.
        $dataSource = null !== $source ? $source : SourceEnum::DATAHUB;

        switch ($dataSource) {
            case SourceEnum::DATAHUB:
                if ($refresh_token) {
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
                    if ($source == SourceEnum::DATAHUB) {
                        //DATAHUB was explicit chosen as provider, but refresh token isn't provided
                        throw new \InvalidArgumentException('When querying Datahub a refresh token must be provided');
                    }
                }
            case SourceEnum::POWERUSE:
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

    /**
     * @param string $refreshToken
     * @return ElOverblikApiInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Tvup\ElOverblikApi\ElOverblikApiException
     */
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

    private function getMeteringPointFromCache(string $key): ?array
    {
        return cache($key) ?? null;
    }
}
