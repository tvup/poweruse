<?php

namespace App\Actions\ElectricityPrices;

use App\Services\GetDatahubPriceLists;
use Illuminate\Support\Str;

class RetrieveTariffFromOperator
{
    /**
     * @param string $operator
     * @param string $chargeType
     * @param string $chargeTypeCode
     * @param string $note
     * @param string $startDate
     * @param string|null $endDate
     * @return array<int, float>
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle(string $operator, string $chargeType, string $chargeTypeCode, string $note, string $startDate, string $endDate = null): array
    {
        $service = app()->make(GetDatahubPriceLists::class);
        $data = $service->requestDatahubPriceListsFromEnergiDataService($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate);
        $collection = collect($data[0]);
        $gridprices = [];
        $collection->each(function ($item, $key) use (&$gridprices) {
            if (is_string($key) && Str::contains($key, 'Price')) {
                $cleanedKey = (string) Str::replace('Price', '', $key);
                if (is_numeric($cleanedKey)) {
                    $index = (int) $cleanedKey - 1;
                    $gridprices[$index] = $item;
                }
            }
        });

        return $gridprices;
    }
}
