<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetSpotPrices
{
    public function getData(string $start_date, string $end_date, string $price_area)
    {
        $parameters = ['start' => $start_date, 'end' => $end_date, 'filter' => '{"PriceArea":"' . $price_area . '"}', 'columns' => 'HourDK,SpotPriceDKK'];
        $url = 'https://api.energidataservice.dk/dataset/Elspotprices';

        $response = Http::acceptJson()
            ->get($url, $parameters);

        $array = array_reverse($response['records']);
        $new_array = array();
        foreach ($array as $data) {
            $new_array[$data['HourDK']] = $data['SpotPriceDKK'];
        }
        return $new_array;
    }
}