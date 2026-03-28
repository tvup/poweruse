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
        ?string $start_date = null,
        ?string $end_date = null,
        ?string $price_area = null,
        $columns = ['HourDK', 'SpotPriceDKK'],
        $format = self::FORMAT_INTERNAL
    ): array|JsonResponse {
        $array = [];
        for ($i = 0; $i < 100; $i++) {
            $array[$i] = 160 + ($i * 2.0);
        }

        return $array;
    }
}
