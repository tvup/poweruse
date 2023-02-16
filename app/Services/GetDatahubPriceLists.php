<?php

namespace App\Services;

use App\Models\DatahubPriceList;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetDatahubPriceLists
{
    /**
     * @param string $operator
     * @param string $chargeType
     * @param string $chargeTypeCode
     * @param string $note
     * @param string $startDate
     * @param string|null $endDate
     * @return array
     */
    public function requestDatahubPriceListsFromEnergiDataService(string $operator, string $chargeType, string $chargeTypeCode, string $note, string $startDate, string $endDate = null): array
    {
        if (!$endDate) {
            $endDate = Carbon::parse($startDate, 'Europe/Copenhagen')->addDay()->toDateString();
        }
        $GLN_number = DatahubPriceList::whereChargeowner($operator)->firstOrFail()->GLN_Number;
        $url = 'https://api.energidataservice.dk/dataset/DatahubPricelist';
        $queryParameters = [
            'start' => substr($startDate, 0, 10),
            'end' => substr($endDate, 0, 10),
            'filter' => '{'
                . '"ChargeType":"' . $chargeType . '",'
                . '"ChargeTypeCode":"' . $chargeTypeCode . '",'
                . '"GLN_Number":"' . $GLN_number . '",'
                . '"Note":"' . $note . '"'
                . '}',
        ];

        return Http::acceptJson()
            ->get($url, $queryParameters)->json('records');
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function requestAllDatahubPriceListsFromEnergiDataService(int $limit = 100, int $offset = 0): array
    {
        $url = 'https://api.energidataservice.dk/dataset/DatahubPricelist';
        $queryParameters = [
            'limit' => $limit,
            'offset' => $offset,
        ];

        return Http::acceptJson()
            ->get($url, $queryParameters)->json('records');
    }

    /**
     * @param string $name
     * @param string $gln_number
     * @param string $description
     * @param string $toDate
     * @param string $fromDate
     * @return Builder
     */
    public function getQueryForFetchingSpecificTariffFromDB(string $name, string $gln_number, string $description, string $toDate, string $fromDate) : Builder
    {
        return DatahubPriceList::whereNote($name)->whereGlnNumber($gln_number)->whereDescription($description)->whereRaw('NOT (ValidFrom > \'' . $toDate . '\' OR (IF(ValidTo is null,\'2030-01-01\',ValidTo) < \'' . $fromDate . '\' ))');
    }

    /**
     * @param Builder $query
     * @return Collection<int, DatahubPriceList>
     */
    public function getFromQuery(Builder $query): Collection
    {
        return $query->get();
    }
}
