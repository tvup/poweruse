<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetSpotPrices
{
    const FORMAT_INTERNAL = 'INTERNAL';
    const FORMAT_JSON = 'JSON';

    public function getData(string $start_date = null, string $end_date = null, string $price_area, $columns = ['HourDK','SpotPriceDKK'], $format = self::FORMAT_INTERNAL)
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

        if($format == self::FORMAT_INTERNAL) {
            $array = array_reverse($response['records']);
            $new_array = array();
            foreach ($array as $data) {
                $new_array[$data['HourDK']] = $data['SpotPriceDKK'];
            }
            $response = $new_array;
        }
        return is_array($response) ? $response : $response->json();
    }
}