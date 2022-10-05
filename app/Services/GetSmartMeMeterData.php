<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GetSmartMeMeterData
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function getFromDate($smartMe = false, $start_date = null)
    {
        if (!$start_date) {
            $start_date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
        }
        list($id, $username, $password) = $this->smartMeCredentials($smartMe);
        $response = Http::withBasicAuth($username, $password)->acceptJson()
            ->get('https://smart-me.com/api/MeterValues/' . $id,
                ['date' => $start_date]);

        return $response['CounterReading'];
    }

    /**
     * @param false $smartMe
     * @param $start_date Date and time in local time to get consumption data from (inclusive)
     * @param null $to_date Date and time in local time to get consumption data untill (exclusive)
     * @return array
     */
    public function getInterval($smartMe = false, $start_date, $to_date=null): array
    {
        $newResponse = null;
        $start_date = Carbon::parse($start_date, 'Europe/Copenhagen')->timezone('UTC')->format('Y-m-d\TH:i:s\Z');
        $to_date = Carbon::parse($to_date, 'Europe/Copenhagen')->timezone('UTC')->format('Y-m-d\TH:i:s\Z');
        $oldResponse = $this->getFromDate($smartMe, $start_date);
        $array = array();
        while ($to_date ? ($oldResponse != $newResponse && !Carbon::parse($start_date, 'UTC')->eq(Carbon::parse($to_date, 'UTC'))) : ($oldResponse != $newResponse)) {
            if ($newResponse) {
                $oldResponse = $newResponse;
            }
            $start_date = Carbon::parse($start_date, 'UTC');
            $rtnStart_date = clone $start_date;
            $start_date->addHour();
            $start_date_formatted = $start_date->format('Y-m-d\TH:i:s\Z');
            $newResponse = $this->getFromDate($smartMe, $start_date_formatted);
            $array[$rtnStart_date->setTimezone('Europe/Copenhagen')->format('Y-m-d\TH:i:s')] = str_replace(',', '.', round($newResponse - $oldResponse, 2));
        }
        return $array;
    }

    /**
     * @param $smartMe
     * @return array
     */
    private function smartMeCredentials($smartMe): array
    {
        $id = ($smartMe && is_array($smartMe) && array_key_exists('id', $smartMe)) ? $smartMe['id'] : config('services.smartme.id');
        $username = ($smartMe && is_array($smartMe) && array_key_exists('username', $smartMe)) ? $smartMe['username'] : config('services.smartme.username');
        $password = ($smartMe && is_array($smartMe) && array_key_exists('password', $smartMe)) ? $smartMe['password'] : config('services.smartme.paasword');
        return array($id, $username, $password);
    }
}