<?php

namespace App\Services;

use Carbon\Carbon;
use Tvup\ElOverblikApi\ElOverblikApiException;
use Tvup\ElOverblikApi\ElOverblikApiInterface;
use Tvup\EwiiApi\EwiiApiException;

class GetMeteringData
{


    /**
     * @var mixed
     */
    private $energiOverblikApi;

    private $meteringPoint;
    private $ewiiApi;


    public function getData($refreshToken = null, $start_date, $end_date, $debug = false)
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

    public function getDataFromEwii($email = null, $password = null, $start_date, $end_date)
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

    public function getMeteringPoint(string $refresh_token = null, $debug = false)
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

    public function getMeteringPointData(string $refresh_token = null)
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

    public function getMeteringPointDataFromEwii(string $email = null, string $password = null)
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

    public function getCharges(string $refresh_token = null)
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
                    $this->table(array_keys($errors), [array_values($errors)]);
                    break;
                case 'string':
                    $this->error($errors);
                    break;
                default:
                    $this->error('Exception didn\'t return useful error messages either');

            }
            throw $exception;

        }

        return array($subscriptions, $tariffs);
    }

    /**
     * @param null $refreshToken
     * @return ElOverblikApiInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getEloverblikApi($refreshToken = null)
    {
        if (!$this->energiOverblikApi) {
            $this->energiOverblikApi = app()->makeWith('Tvup\ElOverblikApi\ElOverblikApiInterface', [
                'refreshToken' => $refreshToken
            ]);
        }
        return $this->energiOverblikApi;
    }

    private function getEwiiApi($email=null, $password=null)
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