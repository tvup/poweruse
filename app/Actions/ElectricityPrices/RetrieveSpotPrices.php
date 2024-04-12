<?php

namespace App\Actions\ElectricityPrices;

use App\Services\GetSpotPrices;
use Carbon\Carbon;

class RetrieveSpotPrices
{
    public function handle(string $area, Carbon $from = null) : array
    {
        if (!$from) {
            $from = Carbon::now('Europe/Copenhagen')->startOfDay();
        }
        $startDate = $from->toDateString();
        $endDate = $from->addDay()->toDateString();
        $service = app()->make(GetSpotPrices::class);

        /** @var array $array */
        $array = $service->getData($startDate, $endDate, $area, ['HourDK', 'SpotPriceDKK']);

        return array_values($array);
    }
}
