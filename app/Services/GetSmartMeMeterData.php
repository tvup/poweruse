<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GetSmartMeMeterData
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function getFromDate(array $smartMe = null, string $start_date = null)
    {
        logger()->info('attemt ssss');

        if (!$start_date) {
            $start_date = Carbon::now('Europe/Copenhagen')->startOfHour()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
        }
        list($id, $username, $password) = $this->smartMeCredentials($smartMe);

        $response = Http::withBasicAuth($username, $password)->acceptJson()
            ->retry(3, function (int $attempt, \Exception $exception)
                {
                    logger()->info('attempt ' . $attempt);
                    return 100;
                }
            )
            ->get(
//                'https://smart-me.com/api/MeterValues/' . $id,
                'https://testpu.free.beeceptor.com/todo',
                ['date' => $start_date]
            );

        return $response['CounterReading'];
    }

    /**
     * @param string $start_date_copenhagen Date and time in local time to get consumption data from (inclusive)
     * @param string|null $to_date Date and time in local time to get consumption data untill (exclusive)
     * @param array $smartMe
     * @return array
     * @throws \Exception
     */
    public function getInterval(string $start_date_copenhagen, string $to_date = null, array $smartMe = []): array
    {
        $newResponse = null;
        $start_date_copenhagen = Carbon::parse($start_date_copenhagen, 'Europe/Copenhagen');
        $start_date_utc = clone $start_date_copenhagen;
        $start_date_utc = $start_date_utc->timezone('UTC');
        $start_date_utc_formatted = $start_date_utc->format('Y-m-d\TH:i:s\Z');

        $timeZone = new DateTimeZone('Europe/Copenhagen');
        $start = clone $start_date_copenhagen;
        $start = new DateTime($start->startOfYear()->toDateString(), $timeZone);
        $year_add_to_start_date_copenhagen = clone $start_date_copenhagen;
        $end = new DateTime($year_add_to_start_date_copenhagen->startOfYear()->addYear()->toDateString(), $timeZone);
        $year_late_transition = $timeZone->getTransitions((int) $start->format('U'), (int) $end->format('U'))[2];
        $late_transition_end_hour = Carbon::parse($year_late_transition['time'])->timezone('Europe/Copenhagen')->addHour();
        /** @var CarbonTimeZone $timeZone2 */
        $timeZone2 = CarbonTimeZone::create('+2');
        $timeZone2 = new DateTimeZone($timeZone2->getName());
        $late_transition_end_hour2 = Carbon::create(2022, 10, 30, 2, 0, 0, $timeZone2); //TODO: Should be created from $late_transition_end_hour
        if (!$late_transition_end_hour2) {
            throw new \Exception('Could not create late_transition_end_hour2');
        }
        $nice_one = $late_transition_end_hour2->format('c');

        $to_date = Carbon::parse($to_date, 'Europe/Copenhagen');

        $oldResponse = $this->getFromDate($smartMe, $start_date_utc_formatted);
        $array = [];
        $first = false;
        while ($oldResponse != $newResponse && !$start_date_copenhagen->eq($to_date)) {
            if ($newResponse) {
                $oldResponse = $newResponse;
            }

            $rtn_start_date = clone $start_date_copenhagen;
            $rtn_start_date_formatted = $rtn_start_date->format('c');
            $start_date_copenhagen->addHour();
            $another = clone $start_date_copenhagen;
            $new_start_date_utc = $another->timezone('UTC');
            $new_start_date_formatted = $new_start_date_utc->format('Y-m-d\TH:i:s\Z');

            $newResponse = $this->getFromDate($smartMe, $new_start_date_formatted);

            if (!$first && $start_date_copenhagen->eq($late_transition_end_hour)) {
                $first = true;
                /** @var CarbonTimeZone $timeZone */
                $timeZone = CarbonTimeZone::create('+1');
                $timeZone = new DateTimeZone($timeZone->getName());
                $rtn_start_date_formatted = $rtn_start_date->timezone($timeZone)->format('c');
                $array[$nice_one] = round($newResponse - $oldResponse, 2);
            }
            $array[$rtn_start_date_formatted] = round($newResponse - $oldResponse, 2);
        }

        return $array;
    }

    /**
     * @param $smartMe
     * @return array
     */
    private function smartMeCredentials(array $smartMe = null): array
    {
        $id = ($smartMe && array_key_exists('id', $smartMe)) ? $smartMe['id'] : config('services.smartme.id');
        $username = ($smartMe && array_key_exists('username', $smartMe)) ? $smartMe['username'] : config('services.smartme.username');
        $password = ($smartMe && array_key_exists('password', $smartMe)) ? $smartMe['password'] : config('services.smartme.paasword');

        return [$id, $username, $password];
    }
}
