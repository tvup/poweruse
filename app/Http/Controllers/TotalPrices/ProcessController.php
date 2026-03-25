<?php

namespace App\Http\Controllers\TotalPrices;

use App\Actions\ElectricityPrices\RetrieveSpotPrices;
use App\Actions\ElectricityPrices\RetrieveTariffFromOperator;
use App\Http\Controllers\Controller;
use App\Models\DatahubPriceList;
use App\Models\Operator;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcessController extends Controller
{
    private RetrieveSpotPrices $retrieveSpotPrices;

    public function __construct(RetrieveSpotPrices $retrieveSpotPrices)
    {
        $this->retrieveSpotPrices = $retrieveSpotPrices;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $warning = false;
        $includeTomorrow = false;
        if (Carbon::now('Europe/Copenhagen')->gt(now()->startOfHour()->hour(13))) {
            $includeTomorrow = true;
        }

        $priceArea = $request->area;
        //Input-request contains two keys: Note and Chargeowner seperated by "//"
        $priceListKeys = explode('//', $request->netcompany);

        //Get tariff for grid operator
        $gridOperatorTariffPrices = $this->getGridOperatorTariffPrices($priceListKeys);
        //Get spot prices
        $spotPrices = $this->retrieveSpotPrices->handle(
            area: $priceArea,
        );

        //Check if spot prices were received
        if (count($spotPrices) == 0) {
            $message = 'It wasn\'t possible to get today\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';

            return redirect('totalprices')->with('error', $message)->withInput($request->all());
        }

        $todayIsDstEarlyTransitionDate = null;
        $todayIsDstLateTransitionDate = null;
        $tomorrowIsDstEarlyTransitionDate = null;
        $tomorrowIsDstLateTransitionDate = null;

        list($early_transition_end_hour, $late_transition_end_hour) = $this->getTransitionHours();
        if ($early_transition_end_hour->dayOfYear == now()->dayOfYear) {
            $todayIsDstEarlyTransitionDate = $early_transition_end_hour->hour - 1;
        }
        if ($late_transition_end_hour->dayOfYear == now()->dayOfYear) {
            $todayIsDstLateTransitionDate = $late_transition_end_hour->hour + 1;
        }
        if ($early_transition_end_hour->dayOfYear == now()->addDay()->dayOfYear) {
            $tomorrowIsDstEarlyTransitionDate = $early_transition_end_hour->hour - 1 + 24;
        }
        if ($late_transition_end_hour->dayOfYear == now()->addDay()->dayOfYear) {
            $tomorrowIsDstLateTransitionDate = $late_transition_end_hour->hour + 1 + 24;
        }

        //Add tomorrows spotprices if requested
        if ($includeTomorrow) {
            $from = Carbon::now('Europe/Copenhagen')->startOfDay()->addDay();
            $toMorrowSpotPrices = $this->retrieveSpotPrices->handle(
                area: $priceArea,
                from: $from
            );

            //Check if spot prices for tomorrow were received
            if (count($toMorrowSpotPrices) == 0) {
                $warning = 'It wasn\'t possible to get tomorrow\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
                $includeTomorrow = false;
            }

            $spotPrices = array_merge($spotPrices, $toMorrowSpotPrices);
        }
        //Get other tariffs
        $tsoNetTariffPrices = $this->getTSOOperatorNettariff('Energinet Systemansvar A/S (SYO)');
        $tsoSystemTariffPrices = $this->getTSOOperatorSystemtariff('Energinet Systemansvar A/S (SYO)');
        $tsoAfgiftTariffPrices = $this->getTSOOperatorAfgifttariff('Energinet Systemansvar A/S (SYO)');

        $totalPrice = [];
        $startOfCurrentHour = Carbon::now('Europe/Copenhagen')->startOfHour();
        $startOfCurrentDay = $startOfCurrentHour->copy()->startOfDay();

        // Detect spot price resolution: 15-min (96/day) or hourly (24/day)
        // With includeTomorrow, hourly=~48, quarterly=~192
        $spotPriceIsQuarterly = count($spotPrices) > ($includeTomorrow ? 50 : 25);
        $intervalsPerHour = $spotPriceIsQuarterly ? 4 : 1;
        $intervalsPerDay = $spotPriceIsQuarterly ? 96 : 24;

        $currentInterval = $spotPriceIsQuarterly
            ? $startOfCurrentHour->hour * 4 + intdiv(now('Europe/Copenhagen')->minute, 15)
            : $startOfCurrentHour->hour;

        $limit = $includeTomorrow ? ($intervalsPerDay * 2 - 1) : ($intervalsPerDay - 1);
        if ($todayIsDstEarlyTransitionDate || $tomorrowIsDstEarlyTransitionDate) {
            $limit = $limit - $intervalsPerHour;
        }
        if ($todayIsDstLateTransitionDate || $tomorrowIsDstLateTransitionDate) {
            $limit = $limit + $intervalsPerHour;
        }

        foreach (range($currentInterval, $limit) as $interval) {
            $intervalOnDay = ($interval < $intervalsPerDay ? $interval : $interval - $intervalsPerDay);
            $hourOnDay = $spotPriceIsQuarterly ? intdiv($intervalOnDay, 4) : $intervalOnDay;

            if ($includeTomorrow && ($todayIsDstLateTransitionDate && ($interval >= ($intervalsPerDay - $intervalsPerHour) && $interval - $intervalsPerDay >= $todayIsDstLateTransitionDate * $intervalsPerHour))) {
                $hourOnDay = $spotPriceIsQuarterly ? intdiv($intervalOnDay - 4, 4) : $intervalOnDay - 1;
            }

            if ($includeTomorrow && ($tomorrowIsDstLateTransitionDate && ($interval >= ($intervalsPerDay - $intervalsPerHour) && $interval >= $tomorrowIsDstLateTransitionDate * $intervalsPerHour))) {
                $hourOnDay = $spotPriceIsQuarterly ? intdiv($intervalOnDay - 4, 4) : $intervalOnDay - 1;
            }

            // Calculate total price without VAT
            $netAmount = $gridOperatorTariffPrices[$hourOnDay] + ($spotPrices[$interval] / 1000) + $tsoNetTariffPrices[0] + $tsoSystemTariffPrices[0] + $tsoAfgiftTariffPrices[0];
            // Add 25% VAT
            $grossAmount = $netAmount * 1.25;
            // Round to two decimals and add to array as datetime-index
            $minutesFromStart = $spotPriceIsQuarterly ? $interval * 15 : $interval * 60;
            $timeOnDay = Str::replace('T', ' ', $startOfCurrentDay->copy()->addMinutes($minutesFromStart)->toRfc3339String());
            $totalPrice[$timeOnDay] = round($grossAmount, 2);
        }
        $companies = cache('companies-list for total prices', []);

        $chart = null;
        $data = null;
        switch ($request->outputformat) {
            case 'JSON':
                $data = $totalPrice;
                break;
            case 'GRAF':
                $colours = $this->makeColors(array_values($totalPrice));

                $chart = new \stdClass();
                $array_keys = array_keys($totalPrice);
                array_walk($array_keys, function (&$value) {
                    $value = Str::substr($value, 0, -6);
                });
                $chart->labels = ($array_keys);
                $chart->dataset = (array_values($totalPrice));
                $chart->colours = $colours;
            default:
                break;
        }

        if ($warning) {
            return redirect('totalprices')->with(
                'warning',
                $warning
            )->with(
                'status',
                __('All data collected')
            )->with(['data' => $data])->with(['chart' => $chart])->with(
                'companies',
                $companies
            )->withInput($request->all())->withCookie(
                'outputformat',
                $request->outputformat,
                525600
            )->withCookie('netcompany', $request->netcompany, 525600);
        }

        return redirect('totalprices')->with(
            'status',
            __('All data collected')
        )->with(['data' => $data])->with(['chart' => $chart])->with(
            'companies',
            $companies
        )->withInput($request->all())->withCookie(
            'outputformat',
            $request->outputformat,
            525600
        )->withCookie('netcompany', $request->netcompany, 525600);
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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

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
        $startDate = '2024-01-01';
        $endDate = '2024-12-31';

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
     * @param array<string> $priceListKeys
     * @return array<int, float>
     */
    private function getGridOperatorTariffPrices(array $priceListKeys): array
    {
        $datahubPriceList = DatahubPriceList::query()
            ->whereNote($priceListKeys[1])
            ->whereChargeowner($priceListKeys[0])
            ->isValid(now('Europe/Copenhagen')->startOfDay())
            ->firstOrFail();

        $gridOperatorTariffPrices = [];
        collect($datahubPriceList)->each(function ($item, $key) use (&$gridOperatorTariffPrices) {
            if (Str::contains((string) $key, 'Price')) {
                $key = ((float) Str::replace('Price', '', (string) $key)) - 1;
                $gridOperatorTariffPrices[$key] = floatval($item);
            }
        });

        return $gridOperatorTariffPrices;
    }

    /**
     * @return array<\Illuminate\Support\Carbon>
     * @throws \Exception
     */
    private function getTransitionHours(): array
    {
        $timeZone = new DateTimeZone('Europe/Copenhagen');
        $start_date = \Illuminate\Support\Carbon::now('Europe/Copenhagen')->toDateTimeString();
        $end_date = \Illuminate\Support\Carbon::now('Europe/Copenhagen')->addDay()->toDateTimeString();
        $start = new DateTime(
            \Illuminate\Support\Carbon::parse($start_date, 'Europe/Copenhagen')->startOfYear()->toDateString(),
            $timeZone
        );
        $end = new DateTime(
            \Illuminate\Support\Carbon::parse($end_date, 'Europe/Copenhagen')->startOfYear()->addYear()->toDateString(),
            $timeZone
        );
        $transitions = $timeZone->getTransitions((int) $start->format('U'), (int) $end->format('U'));
        $year_early_transition = $transitions[1];
        $year_late_transition = $transitions[2];
        $early_transition_end_hour = \Illuminate\Support\Carbon::parse($year_early_transition['time'])->timezone(
            'Europe/Copenhagen'
        );
        $late_transition_end_hour = \Illuminate\Support\Carbon::parse($year_late_transition['time'])->timezone(
            'Europe/Copenhagen'
        );

        return [$early_transition_end_hour, $late_transition_end_hour];
    }
}
