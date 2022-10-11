<?php

namespace App\Services;

use App\Models\DatahubPriceList;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GetDatahubPriceLists
{
    public function getDatahubTariffPriceLists($operator, $chargeType, $chargeTypeCode, $note, $startDate, $endDate=null)
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
            . '"TaxIndicator":"0",'
            . '"GLN_Number":"' . $GLN_number . '",'
            . '"Note":"' . $note . '",'
            . '"ResolutionDuration":"PT1H"'
            . '}';
        $response = Http::acceptJson()
            ->get($url);
        return $response->json()['records'];
    }
}