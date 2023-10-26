<?php

namespace App\Http\Controllers\TotalPrices;

use App\Actions\ElectricityPrices\RetrieveSpotPrices;
use App\Actions\ElectricityPrices\RetrieveTariffFromOperator;
use App\Http\Controllers\Controller;
use App\Models\DatahubPriceList;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcessController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $includeTomorrow = false;
        if (Carbon::now('Europe/Copenhagen')->gt(Carbon::now()->startOfHour()->hour(13))) {
            $includeTomorrow = true;
        }

        $priceArea = $request->area;

        //Input-request contains two keys: Note and Chargeowner seperated by "//"
        $priceListKeys = explode('//', $request->netcompany);

        //Get tariff for grid operator
        $gridOperatorTariffPrices = $this->getGridOperatorTariffPrices($priceListKeys);

        //Get spot prices
        $spotPrices = (new RetrieveSpotPrices())->handle(
            area: $priceArea,
        );

        //Check if spot prices were received
        if (count($spotPrices) == 0) {
            $message = 'It wasn\'t possible to get day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';

            return redirect('totalprices')->with('error', $message)->withInput($request->all());
        }

        //Add tomorrows spotprices if requested
        if ($includeTomorrow) {
            $toMorrowSpotPrices = (new RetrieveSpotPrices())->handle(
                area: $priceArea,
                from: Carbon::now('Europe/Copenhagen')->startOfDay()->addDay()
            );
            $spotPrices = array_merge($spotPrices, $toMorrowSpotPrices);
        }

        //Get other tariffs
        $tsoNetTariffPrices = $this->getTSOOperatorNettariff('Energinet Systemansvar A/S (SYO)');
        $tsoSystemTariffPrices = $this->getTSOOperatorSystemtariff('Energinet Systemansvar A/S (SYO)');
        //$tsoBalanceTariffPrices = $this->getTSOOperatorBalancetariff('Energinet Systemansvar A/S (SYO)');
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');

        $totalPrice = [];
        $startOfCurrentHour = Carbon::now('Europe/Copenhagen')->startOfHour();
        $currentHour = $startOfCurrentHour->hour;
        $startOfCurrentDay = $startOfCurrentHour->startOfDay();

        $limit = $includeTomorrow ? 47 : 23;
        foreach (range($currentHour, $limit) as $hour) {
            $hourOnDay = ($hour <= 23 ? $hour : $hour - 24);
            // Calculate total price without VAT
            $netAmount = $gridOperatorTariffPrices[$hourOnDay] + ($spotPrices[$hour] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoAfgiftTariffPrices[0];
            // Add 25% VAT
            $grossAmount = $netAmount * 1.25;
            // Round to two decimals and add to array as datetime-index eg. "2023-02-01 02:00:00"
            $timeOnDay = $startOfCurrentDay->copy()->addHours($hour)->toDateTimeString();
            $totalPrice[$timeOnDay] = round($grossAmount, 2);
        }
        $companies = Operator::$operatorName;

        $chart = null;
        $data = null;
        switch ($request->outputformat) {
            case 'JSON':
                $data = $totalPrice;
                break;
            case 'GRAF':
                $colours = $this->makeColors(array_values($totalPrice));

                $chart = new \stdClass();
                $chart->labels = (array_keys($totalPrice));
                $chart->dataset = (array_values($totalPrice));
                $chart->colours = $colours;
            default:
                break;
        }

        return redirect('totalprices')->with('status', __('All data collected'))->with(['data' => $data])->with(['chart' => $chart])->with('companies', $companies)->withInput($request->all())->withCookie('outputformat', $request->outputformat, 525600)->withCookie('netcompany', $request->netcompany, 525600);
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorNettariff(string $operator): array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '40000';
        $note = 'Transmissions nettarif';
        $startDate = '2023-01-01';
        $endDate = '2023-12-31';

        return (new RetrieveTariffFromOperator())->handle(
            operator: $operator,
            chargeType: $chargeType,
            chargeTypeCode: $chargeTypeCode,
            note: $note,
            startDate: $startDate,
            endDate: $endDate,
        );
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorSystemtariff(string $operator): array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '41000';
        $note = 'Systemtarif';
        $startDate = '2023-01-01';
        $endDate = '2023-12-31';

        return (new RetrieveTariffFromOperator())->handle(
            operator: $operator,
            chargeType: $chargeType,
            chargeTypeCode: $chargeTypeCode,
            note: $note,
            startDate: $startDate,
            endDate: $endDate,
        );
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorBalancetariff(string $operator): array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '45013';
        $note = 'Balancetarif for forbrug';
        $startDate = '2022-01-01';
        $endDate = '2023-12-31';

        return (new RetrieveTariffFromOperator())->handle(
            operator: $operator,
            chargeType: $chargeType,
            chargeTypeCode: $chargeTypeCode,
            note: $note,
            startDate: $startDate,
            endDate: $endDate,
        );
    }

    /**
     * @param string $operator
     * @return array<int, float>
     */
    private function getTSOOperatorAfgifttariff(string $operator): array
    {
        $chargeType = 'D03';
        $chargeTypeCode = 'EA-001';
        $note = 'Elafgift';
        $startDate = '2023-0LAd 7-01';
        $endDate = '2024-01-01';

        return (new RetrieveTariffFromOperator())->handle(
            operator: $operator,
            chargeType: $chargeType,
            chargeTypeCode: $chargeTypeCode,
            note: $note,
            startDate: $startDate,
            endDate: $endDate,
        );
    }

    /**
     * @param array<float> $array
     * @return array<string>
     */
    private function makeColors(array $array): array
    {
        $min = (float) min($array);
        $max = (float) max($array);
        $colours = [];
        foreach ($array as $value) {
            $value = (float) $value;
            $percentage = ($value - $min) / ($max - $min);
            $percentage = $percentage * 100.0;

            $R = 0;
            $G = 0;
            $B = 0;

            // 255 ÷ 50 = 5.1
            if ($percentage > 50) {
                $R = 5.1 * ($percentage - 50);
            } elseif ($percentage < 50) {
                $G = 255 - (5.1 * $percentage);
            }

            $dechex_r = dechex((int) $R) === '0' ? '00' : dechex((int) $R);
            $dechex_g = dechex((int) $G) === '0' ? '00' : dechex((int) $G);
            $dechex_b = dechex((int) $B) === '0' ? '00' : dechex((int) $B);

            $colours[] = '#' . $dechex_r . $dechex_g . $dechex_b;
        }

        return $colours;
    }

    /**
     * @param array<string> $array
     * @return array<int, float>
     */
    private function getGridOperatorTariffPrices(array $array): array
    {
        $toDay = Carbon::now('Europe/Copenhagen')->startOfDay()->toDateString();
        $datahubPriceList = DatahubPriceList::whereNote($array[1])->whereChargeowner($array[0])->whereRaw('\'' . $toDay . '\' between ValidFrom and ValidTo')->firstOrFail();
        $collection = collect($datahubPriceList);
        $gridOperatorTariffPrices = [];
        $collection->each(function ($item, $key) use (&$gridOperatorTariffPrices) {
            if (Str::contains($key, 'Price')) {
                $key = ((int) Str::replace('Price', '', $key)) - 1;
                $gridOperatorTariffPrices[$key] = $item;
            }
        });

        return $gridOperatorTariffPrices;
    }
}
