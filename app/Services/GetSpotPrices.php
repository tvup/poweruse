<?php

namespace App\Services;

use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class GetSpotPrices
{
    const FORMAT_INTERNAL = 'INTERNAL';
    const FORMAT_JSON = 'JSON';

    /**
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string $price_area
     * @param string[] $columns
     * @param string $format
     * @return array|JsonResponse
     * @throws \Exception
     */
    public function getData(string $start_date = null, string $end_date = null, string $price_area, $columns = ['HourDK','SpotPriceDKK'], $format = self::FORMAT_INTERNAL) : array|JsonResponse
    {
        $parameters = array();
        if(!$start_date){
            $start_date = 'Now-PT12H';
        }
        $parameters = array_merge($parameters, ['start' => $start_date]);

        if($end_date){
            $parameters = array_merge($parameters, ['end' => $end_date]);
        }

        if($price_area != 'ALL') {
            $parameters = array_merge($parameters, ['filter' => '{"PriceArea":"' . $price_area . '"}']);
        }
        if(count($columns)>0) {
            $parameters = array_merge($parameters, ['columns' => implode(',',$columns)]);
        }

        $url = 'https://api.energidataservice.dk/dataset/Elspotprices';
        $response = Http::acceptJson()
            ->get($url, $parameters);

        $timeZone = new DateTimeZone('Europe/Copenhagen');
        $start = new DateTime(Carbon::parse($start_date)->startOfYear()->toDateString(), $timeZone);
        $end = new DateTime(Carbon::parse($end_date)->startOfYear()->addYear()->toDateString(), $timeZone);

        $transitions = $timeZone->getTransitions((int) $start->format('U'), (int) $end->format('U'));
        $year_late_transition = $transitions[2];
        $late_transition_end_hour = Carbon::parse($year_late_transition['time'])->timezone('Europe/Copenhagen');

        $first = false;
        if($format == self::FORMAT_INTERNAL) {
            $array = array_reverse($response['records']);
            $new_array = [];
            foreach ($array as $data) {
                $carbon = Carbon::parse($data['HourDK'], 'Europe/Copenhagen');
                if (!$first && $carbon->eq($late_transition_end_hour)) {
                    $first = true;
                    $timeZone2 = CarbonTimeZone::create('+2');
                    $late_transition_end_hour2 = Carbon::create(2022, 10, 30, 2, 0, 0, $timeZone2); //TODO: Should be created from $late_transition_end_hour
                    $nice_one = $late_transition_end_hour2->format('c');
                    $new_array[$nice_one] = $data['SpotPriceDKK'];
                } else {
                    $hour = $carbon->format('c');
                    $new_array[$hour] = $data['SpotPriceDKK'];
                }
            }
            $response = $new_array;
        }
        return is_array($response) ? $response : $response->json();
    }
}
