<?php

namespace App\Services;

use App\Services\Interfaces\GetSpotPricesInterface;
use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class GetElprisenSpotPrices implements GetSpotPricesInterface
{
    public const FORMAT_INTERNAL = 'INTERNAL';

    /**
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string|null $price_area
     * @param string[] $columns
     * @param string $format
     * @return array|JsonResponse
     * @throws \Exception
     */
    public function getData(string $start_date = null, string $end_date = null, string $price_area = null, $columns = ['HourDK', 'SpotPriceDKK'], $format = self::FORMAT_INTERNAL) : array|JsonResponse
    {
        if (!$start_date) {
            $start_date = now()->toDateTimeString();
        }

        if (!$end_date) {
            $end_date = now()->addDay()->toDateTimeString();
        }

        $start_date = Carbon::parse($start_date, 'Europe/Copenhagen');
        $end_date = Carbon::parse($end_date, 'Europe/Copenhagen');
        $days = $start_date->diffInDays($end_date);

        if (!$price_area) {
            $price_area = 'DK1';
        }

        $response = [];
        for ($i = 0; $i < $days; $i++) {
            $prices = $this->getPricesForDay($start_date, $price_area, $end_date, $format);
            if (is_array($prices)) {
                $response = array_merge($prices, $response);
            }
            $start_date->addDay();
        }

        return $response;
    }

    /**
     * @param Carbon $start_date
     * @param string|null $price_area
     * @param string|null $end_date
     * @param string $format
     * @return array|\GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Exception
     */
    private function getPricesForDay(
        Carbon $start_date,
        ?string $price_area,
        ?string $end_date,
        string $format
    ): \Illuminate\Http\Client\Response|array|\GuzzleHttp\Promise\PromiseInterface {
        $month = sprintf('%02d', $start_date->month);
        $day = sprintf('%02d', $start_date->day);
        $url = 'https://www.elprisenligenu.dk/api/v1/prices/' . $start_date->year . '/' . $month . '-' . $day . '_' . $price_area . '.json';
        $response = Http::acceptJson()
            ->get($url);

        $array = $response->json();

        $timeZone = new DateTimeZone('Europe/Copenhagen');

        $start = new DateTime(
            Carbon::parse($start_date, 'Europe/Copenhagen')->startOfYear()->toDateString(),
            $timeZone
        );
        $end = new DateTime(
            Carbon::parse($end_date, 'Europe/Copenhagen')->startOfYear()->addYear()->toDateString(),
            $timeZone
        );

        $transitions = $timeZone->getTransitions((int) $start->format('U'), (int) $end->format('U'));
        $year_late_transition = $transitions[2];
        $late_transition_end_hour = Carbon::parse($year_late_transition['time'])->timezone('Europe/Copenhagen');

        $first = false;
        if ($format == self::FORMAT_INTERNAL) {
            $new_array = [];
            foreach ($array as $data) {
                $carbon = Carbon::parse($data['time_start'], 'Europe/Copenhagen');
                if (!$first && $carbon->eq($late_transition_end_hour)) {
                    $first = true;
                    /** @var CarbonTimeZone $timezone */
                    $timezone = CarbonTimeZone::create('+2');
                    $timeZone2 = new DateTimeZone($timezone->getName());
                    $late_transition_end_hour2 = Carbon::create(2022, 10, 30, 2, 0, 0, $timeZone2); //TODO: Should be created from $late_transition_end_hour
                    if (!$late_transition_end_hour2) {
                        throw new \Exception('Could not create late_transition_end_hour2');
                    }
                    $nice_one = $late_transition_end_hour2->format('c');
                    $new_array[$nice_one] = $data['DKK_per_kWh'] * 1000;
                } else {
                    $hour = $carbon->format('c');
                    $new_array[$hour] = $data['DKK_per_kWh'] * 1000;
                }
            }
            $response = $new_array;
        }

        return $response;
    }
}
