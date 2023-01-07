<?php

namespace App\Services;

use App\Models\DatahubPriceList;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GetDatahubPriceLists
{
    /**
     * @return array
     */
    public function getDatahubTariffPriceLists(string $operator, string $chargeType, string $chargeTypeCode, string $note, string $startDate, string $endDate = null): array
    {
        if(!$endDate) {
            $endDate = Carbon::parse($startDate, 'Europe/Copenhagen')->addDay()->toDateString();
        }
        $GLN_number = DatahubPriceList::whereChargeowner($operator)->firstOrFail()->GLN_Number;
        $url = 'https://api.energidataservice.dk/dataset/DatahubPricelist?'
            . 'start=' . substr($startDate,0,10) . '&'
            . 'end=' . substr($endDate,0,10) . '&'
            . 'filter={'
            . '"ChargeType":"' . $chargeType . '",'
            . '"ChargeTypeCode":"' . $chargeTypeCode . '",'
            . '"GLN_Number":"' . $GLN_number . '",'
            . '"Note":"' . $note . '"'
            . '}';
        return Http::acceptJson()
            ->get($url)->json('records');
    }

    /**
     * @return array
     */
    public function getAllDatahubTariffPriceLists(int $limit = 100, int $offset= 0): array
    {
        $url = 'https://api.energidataservice.dk/dataset/DatahubPricelist?limit='.$limit . '&offset='.$offset;
        return Http::acceptJson()
            ->get($url)->json('records');
    }
}
