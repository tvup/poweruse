<?php

namespace App\Services;

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
        $GLN_number = Operator::$operatorNumber[$operator];
        $url = 'https://api.energidataservice.dk/dataset/DatahubPricelist?'
            . 'start=' . $startDate . '&'
            . 'end=' . $endDate . '&'
            . 'filter={'
            . '"ChargeType":"' . $chargeType . '",'
            . '"ChargeTypeCode":"' . $chargeTypeCode . '",'
            . '"GLN_Number":"' . $GLN_number . '",'
            . '"Note":"' . $note . '"'
            . '}';
        return Http::acceptJson()
            ->get($url)->json('records');
    }
}
