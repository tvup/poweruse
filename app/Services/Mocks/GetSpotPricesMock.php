<?php

namespace App\Services\Mocks;

use App\Services\Interfaces\GetSpotPricesInterface;
use Illuminate\Http\JsonResponse;

class GetSpotPricesMock implements GetSpotPricesInterface
{
    public const FORMAT_INTERNAL = 'INTERNAL';

    public const FORMAT_JSON = 'JSON';

    /**
     * @param string|null $start_date
     * @param string|null $end_date
     * @param string|null $price_area
     * @param string[] $columns
     * @param string $format
     * @return array|JsonResponse
     * @throws \Exception
     */
    public function getData(
        string $start_date = null,
        string $end_date = null,
        string $price_area = null,
        $columns = ['HourDK', 'SpotPriceDKK'],
        $format = self::FORMAT_INTERNAL
    ): array|JsonResponse {
        $array =
            [
                0 => 160,
                1 => 168.0,
                2 => 176.0,
                3 => 184,
                4 => 192.0,
                5 => 200.0,
                6 => 208.0,
                7 => 216.0,
                8 => 224.0,
                9 => 232.0,
                10 => 240.0,
                11 => 248.0,
                12 => 256.0,
                13 => 264.0,
                14 => 272.0,
                15 => 280.0,
                16 => 288.0,
                17 => 296.0,
                18 => 304.0,
                19 => 312.0,
                20 => 320.0,
                21 => 328.0,
                22 => 336.0,
                23 => 344.0,
                24 => 352.0,
            ];

        return $array;
    }
}
