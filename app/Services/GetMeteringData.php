<?php

namespace App\Services;

use Carbon\Carbon;
use Tvup\ElOverblikApi\ElOverblikApi;
use Tvup\ElOverblikApi\ElOverblikApiException;
use Tvup\ElOverblikApi\ElOverblikApiInterface;
use Tvup\EwiiApi\EwiiApiException;
use Tvup\EwiiApi\EwiiApiInterface;

class GetMeteringData
{


    private ElOverblikApiInterface|null $energiOverblikApi;

    private EwiiApiInterface|null $ewiiApi;
    private string $meteringPoint;

    /**
     * @param string $start_date
     * @param string $end_date
     * @param null $refreshToken
     * @param bool $debug
     * @return array<string, string>
     * @throws ElOverblikApiException
     */
    public function getData(string $start_date, string $end_date, string $refreshToken = null, bool $debug = false) : array
    {
        if (!$refreshToken) {
            $refreshToken = config('services.energioverblik.refresh_token');
        }

        logger('Accessing EloverblikApi. MD5 of refresh token: ' . md5($refreshToken));
        $energiOverblikApi = $this->getEloverblikApi($refreshToken);

        if ($debug) {
            $energiOverblikApi->setDebug(true);
        }

        $energiOverblikApi->token($refreshToken);

        $meteringPointId = $this->getMeteringPoint($refreshToken, $debug);

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
            $ewiiApi->setSelectedAddressPickerElement($response);
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

    public function getMeteringPoint(string $refresh_token = null, bool $debug = false): string
    {
        $key = 'meteringpoint ' . $refresh_token;
        $meteringPoint = cache($key);
        if ($meteringPoint) {
            return $meteringPoint;
        }
        if (!$this->meteringPoint) {
            if (!$refresh_token) {
                $refresh_token = config('services.energioverblik.refresh_token');
            }

            $energiOverblikApi = $this->getEloverblikApi($refresh_token);

            $energiOverblikApi->setDebug($debug);

            $energiOverblikApi->token($refresh_token);

            try {
                $response = $energiOverblikApi->getFirstMeteringPoint($refresh_token);
            } catch (ElOverblikApiException $e) {
                throw $e;
            }
            $expiresAt = Carbon::now()->addDays(10)->startOfDay();
            cache([$key => $response], $expiresAt);

            $this->meteringPoint = $response;
        }
        return $this->meteringPoint;
    }

    public function getMeteringPointData(string $refresh_token = null): array
    {
        $key = 'meteringPointData ' . $refresh_token;

        $meteringPointData = cache($key);
        if ($meteringPointData) {
            return $meteringPointData;
        }

        if (!$refresh_token) {
            $refresh_token = config('services.energioverblik.refresh_token');
        }

        $energiOverblikApi = $this->getEloverblikApi($refresh_token);

        $energiOverblikApi->token($refresh_token);
        try {
            $response = $energiOverblikApi->getMeteringPointData();
            $expiresAt = now()->addDay()->startOfDay();
            cache([$key => $response], $expiresAt);
        } catch (ElOverblikApiException $e) {
            throw $e;
        }
        return $response;

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

    public function getCharges(string $refresh_token = null): array
    {
        $energiOverblikApi = $this->getEloverblikApi($refresh_token);

        if (!$refresh_token) {
            $refresh_token = config('services.energioverblik.refresh_token');
        }

        $energiOverblikApi->token($refresh_token);

        $meteringPointId = $this->getMeteringPoint($refresh_token);

        try {
            list($subscriptions, $tariffs) = $energiOverblikApi->getCharges($meteringPointId);
        } catch (ElOverblikApiException $exception) {
            if ($exception->getCode() == 503) {
                logger()->error('Datahub not available for getCharges (503)');
                throw $exception;
            }
            logger()->error('Datahub returned error for getCharges for metering point ' . $meteringPointId);
            $errors = $exception->getErrors();
            switch (gettype($errors)) {
                case 'array':
                    logger()->error('Got array of errors', [
                        'errors' => $errors
                    ]);
                    break;
                case 'string':
                    logger()->error($errors);
                    break;
                default:
                    logger()->error('Exception didn\'t return useful error messages either');

            }
            throw $exception;

        }

        return array($subscriptions, $tariffs);
    }

    private function getEloverblikApi(string $refreshToken = null) : ElOverblikApiInterface
    {
        if (!$this->energiOverblikApi) {
            $this->energiOverblikApi = app()->makeWith('Tvup\ElOverblikApi\ElOverblikApiInterface', [
                'refreshToken' => $refreshToken
            ]);
        }
        return $this->energiOverblikApi;
    }

    private function getEwiiApi(string $email = null, string $password = null) : EwiiApiInterface
    {
        if (!$this->ewiiApi) {
            $this->ewiiApi = app()->makeWith('Tvup\EwiiApi\EwiiApiInterface', [
                'email' => $email,
                'password' => $password,
            ]);
        }
        return $this->ewiiApi;
    }

}
