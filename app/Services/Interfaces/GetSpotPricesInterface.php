<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;

interface GetSpotPricesInterface
{
    public function getData(string $start_date, string $end_date, string $price_area, array $columns, string $format) : array|JsonResponse;
}
