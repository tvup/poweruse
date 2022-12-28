<?php

namespace App\Http\Controllers\TotalPrices;

use App\Actions\ElectricityPrices\RetrieveSpotPrices;
use App\Actions\ElectricityPrices\RetrieveTariffFromOperator;
use App\Http\Controllers\Controller;
use App\Models\GridOperatorNettariffProperty;
use App\Models\Operator;
use App\Services\GetDatahubPriceLists;
use App\Services\GetSpotPrices;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    private GetDatahubPriceLists $datahubPriceListsService;
    private GetSpotPrices $spotPricesService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetDatahubPriceLists $datahubPriceListsService, GetSpotPrices $spotPricesService)
    {
        $this->datahubPriceListsService = $datahubPriceListsService;
        $this->spotPricesService = $spotPricesService;
    }

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

        $gridOperatorName = Operator::$operatorName[$request->netcompany];
        $priceArea = Operator::$gridOperatorArea[$gridOperatorName];

        //Get tariff for grid operator
        $gridOperatorTariffPrices = $this->getGridOperatorTariff($gridOperatorName);

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
        $tsoBalanceTariffPrices = $this->getTSOOperatorBalancetariff('Energinet Systemansvar A/S (SYO)');
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');


        $totalPrice = array();
        $now = Carbon::now('Europe/Copenhagen')->startOfHour()->startOfDay();
        $limit = $includeTomorrow ? 47 : 23;
        for ($i = 0; $i <= $limit; $i++) {
            $j = ($i <= 23 ? $i : $i - 24);
            $now2 = clone $now;
            $totalPrice[$now2->addHours($i)->toDateTimeString()] = round(($gridOperatorTariffPrices[$j] + ($spotPrices[$i] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoBalanceTariffPrices[0] + $tsoAfgiftTariffPrices[0]) * 1.25, 2);
        }
        $companies = Operator::$operatorName;

        $colours = $this->makeColors(array_values($totalPrice));

        $chart = new \stdClass();
        $chart->labels = (array_keys($totalPrice));
        $chart->dataset = (array_values($totalPrice));
        $chart->colours = $colours;

        return redirect('totalprices')->with('status', 'Alt data hentet')->with(['data' => $totalPrice])->with(['chart' => $chart])->with('companies', $companies)->withInput($request->all())->withCookie('outputformat', $request->outputformat, 525600)->withCookie('netcompany', $request->netcompany, 525600);
    }

    private function getGridOperatorTariff(string $string)
    {
        $operator_number = Operator::$operatorNumber[$string];
        $operator = GridOperatorNettariffProperty::getByGLNNumber($operator_number);

        $chargeType = $operator->charge_type;
        $chargeTypeCode = $operator->charge_type_code;
        $note = $operator->note;
        $startDate = $operator->valid_from;
        $endDate = $operator->valid_to;

        return (new RetrieveTariffFromOperator())->handle(
            operator: $string,
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
    private function getTSOOperatorNettariff(string $operator): array
    {
        $chargeType = 'D03';
        $chargeTypeCode = '40000';
        $note = 'Transmissions nettarif';
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';

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
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';

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
        $endDate = '2022-12-31';

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
        $startDate = '2022-10-01';
        $endDate = '2022-12-31';

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
        $min = (float)min($array);
        $max = (float)max($array);
        $colours = [];
        foreach ($array as $value) {
            $value = (float)$value;
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

            $dechex_r = dechex((int)$R) === '0' ? '00' : dechex((int)$R);
            $dechex_g = dechex((int)$G) === '0' ? '00' : dechex((int)$G);
            $dechex_b = dechex((int)$B) === '0' ? '00' : dechex((int)$B);

            $colours[] = '#' . $dechex_r . $dechex_g . $dechex_b;
        }
        return $colours;
    }
}
