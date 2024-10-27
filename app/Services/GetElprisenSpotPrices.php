<?php

namespace App\Services;

use App\Services\Interfaces\GetSpotPricesInterface;
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
                $response = array_merge($response, $prices);
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

        if ($format == self::FORMAT_INTERNAL) {
            $new_array = [];
            foreach ($array as $data) {
                $carbon = Carbon::parse($data['time_start'], 'Europe/Copenhagen');
                $hour = $carbon->format('c');
                $new_array[$hour] = $data['DKK_per_kWh'] * 1000;
            }
            $response = $new_array;
        }

        return $response;
    }
}
