<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Tvup\ElOverblikApi\ElOverblikApiException;

class GetPreliminaryInvoice
{
    const ALL_TARIFFS = 'Alle Tariffer';
    /**
     * @var GetMeteringData
     */
    private $meteringDataService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(GetMeteringData $meteringDataService)
    {
        $this->meteringDataService = $meteringDataService;
    }

    /**
     * @param string $start_date
     * @param string $end_date
     * @param $smartMe
     * @param $refreshToken
     * @param $price_area
     * @return array
     * @throws ElOverblikApiException
     */
    public function getBill(string $start_date, string $end_date, $smartMe, $dataSource=null, $refreshToken=null, $ewiiCredentials=null, $price_area, $subscription_at_elsupplier=23.20, $overhead=0.015): array
    {

        if (Carbon::parse($end_date)->greaterThan(Carbon::now()->startOfDay())) {
            if ($smartMe) {
                $end_date = Carbon::now()->startOfHour()->format('Y-m-d\TH:i:s');
            } else {
                $end_date = Carbon::now()->startOfDay()->toDateString();
            }
        }
        if(Carbon::parse($start_date)->startOfDay()->eq(Carbon::parse($end_date)->startOfDay())) {
            if ($smartMe) {
                $end_date = Carbon::now()->addDay()->startOfHour()->format('Y-m-d\TH:i:s');
            } else {
                $end_date = Carbon::now()->addDay()->startOfDay()->toDateString();
            }
        }

        $source = $dataSource;

        switch ($dataSource) {
            case 'EWII':
                if(!$ewiiCredentials && !array_key_exists('ewiiEmail',$ewiiCredentials) && !array_key_exists('ewiiPassword',$ewiiCredentials)) {
                    throw new \InvalidArgumentException('EWII was selected as provider, but email and password for EWII-account wasn\'t given');
                }
                $key = $ewiiCredentials['ewiiEmail'] . ' ' . $start_date . ' ' . $end_date;
                break;
            case 'DATAHUB':
            case null;
                if(!$refreshToken) {
                    throw new \InvalidArgumentException('Eloverblik was selected as provider, but refresh token wasn\'t given');
                }
                $key = $refreshToken . ' ' . $start_date . ' ' . $end_date;
                $source = 'DATAHUB';
                break;
            default:
                throw new \RuntimeException('Illegal provider for meteringdata given: ' . $dataSource);
        }
        $meterData = cache($key);

        try {
            if (!$meterData) {
                switch ($dataSource) {
                    case 'EWII':
                        $meterData = $this->meteringDataService->getDataFromEwii($ewiiCredentials['ewiiEmail'], $ewiiCredentials['ewiiPassword'], $start_date, $end_date);
                        break;
                    case 'DATAHUB':
                    case null:
                        $meterData = $this->meteringDataService->getData($refreshToken, $start_date, $end_date);
                        break;
                    default:
                        throw new \RuntimeException('Illegal provider for meteringdata given: ' . $dataSource);
                }

                $expiresAt = Carbon::now()->addDay()->startOfDay();
                cache([$key => $meterData], $expiresAt);
            }

            if ($smartMe) {
                $source = ($source? : '') . ', Smart-Me';
                if(count($meterData)>0) {
                    $start_from = Carbon::parse(array_key_last($meterData), 'Europe/Copenhagen')->addHour();
                } else {
                    $start_from = Carbon::now('UTC')->startOfDay()->subHour();
                }
                $start_from = $start_from->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');

                $getSmartMeMeterData = new GetSmartMeMeterData();
                $smartMeIntervalFromDate = $getSmartMeMeterData->getInterval($smartMe, $start_from, $end_date);
                $meterData = array_merge($meterData, $smartMeIntervalFromDate);
            }

            if ($smartMe) {
                $key = $start_date . ' ' . Carbon::now('Europe/Copenhagen')->addDay()->toDateString() . ' ' . $price_area;
            } else {
                $key = $start_date . ' ' . Carbon::parse($end_date)->addDay()->toDateString() . ' ' . $price_area;
            }


            $prices = cache($key);
            if (!$prices) {
                if ($smartMe) {
                    $price_end_date = Carbon::now('Europe/Copenhagen')->addDay()->toDateString();
                } else {
                    $price_end_date = Carbon::parse($end_date)->addDay()->toDateString();
                }
                $spotPrices = new GetSpotPrices();
                $prices = $spotPrices->getData($start_date, $price_end_date, $price_area);
                $expiresAt = Carbon::now()->addDay()->startOfDay()->hour(13)->minute(10);
                cache([$key => $prices], $expiresAt);
            }

            $key = 'charges ' . $refreshToken;
            $charges = cache($key);
            if (!$charges) {
                $charges = $this->meteringDataService->getCharges($refreshToken);
                $expiresAt = Carbon::now()->addMonthsNoOverflow(1)->startOfMonth();
                cache([$key => $charges], $expiresAt);
            }
            list($subscriptions, $tariffs) = $charges;

        } catch (ElOverblikApiException $e) {
            logger()->warning('Call to elOverblikApi failed with code ' . $e->getCode());
            throw $e;
        }

        $bill = array();

        if ($smartMe) {
            $to_date = Carbon::parse(array_key_last($meterData), 'Europe/Copenhagen')->toDateTimeString();
        } else {
            $to_date = Carbon::parse(array_key_last($meterData))->addHour()->toDateString();
        }
        $diff_in_days = Carbon::parse($start_date, 'Europe/Copenhagen')->diffInDays(Carbon::parse($to_date, 'Europe/Copenhagen'));
        $bill['meta'] = ['Interval' => ['fra' => $start_date, 'til' => $to_date, 'antal dage' => $diff_in_days+1]];

        $sum = 0;

        $bill['meta']['Interval']['antal timer i intervallet'] = count($meterData);
        //$bill['meta']['Interval']['time'] = array();

        foreach ($meterData as $hour => $consumption) {
            //array_push($bill['meta']['Interval']['time'], $hour);
            //echo $hour . ': ' . $consumption . PHP_EOL;
            foreach ($tariffs as $tariff) {
                if (count($tariff['prices']) > 1) {
                    if (array_key_exists($tariff['name'], $bill)) {
                        $bill[$tariff['name']] = $bill[$tariff['name']] + $tariff['prices'][Carbon::parse($hour)->hour]['price'] * $consumption;
                    } else {
                        $bill[$tariff['name']] = $tariff['prices'][Carbon::parse($hour)->hour]['price'] * $consumption;
                    }
                } else {
                    if (array_key_exists($tariff['name'], $bill)) {
                        $bill[$tariff['name']] = $bill[$tariff['name']] + $tariff['prices'][0]['price'] * $consumption;
                    } else {
                        $bill[$tariff['name']] = $tariff['prices'][0]['price'] * $consumption;
                    }
                }
                $bill[$tariff['name']] = round($bill[$tariff['name']], 2);
            }
            if (array_key_exists('Spotpris', $bill)) {
                if (Carbon::parse($hour, 'Europe/Copenhagen')->lessThanOrEqualTo(Carbon::parse()->now()->startOfHour())) {
                    $bill['Spotpris'] = $bill['Spotpris'] + $consumption * ($prices[$hour] / 1000);
                }
            } else {
                if (Carbon::parse($hour, 'Europe/Copenhagen')->lessThanOrEqualTo(Carbon::parse()->now()->startOfHour())) {
                    $bill['Spotpris'] = $consumption * ($prices[$hour] / 1000);
                }
            }
            $bill['Spotpris'] = round($bill['Spotpris'], 2);

            if (array_key_exists('Overhead', $bill)) {
                if (Carbon::parse($hour, 'Europe/Copenhagen')->lessThanOrEqualTo(Carbon::parse()->now()->startOfHour())) {
                    $bill['Overhead'] = $bill['Overhead'] + $consumption * $overhead;
                }
            } else {
                if (Carbon::parse($hour, 'Europe/Copenhagen')->lessThanOrEqualTo(Carbon::parse()->now()->startOfHour())) {
                    $bill['Overhead'] = $consumption * $overhead;
                }
            }
            $bill['Overhead'] = round($bill['Overhead'], 2);
            $sum = $sum + $consumption;
        }

        $bill['meta']['Forbrug'] = round($sum, 2) . ' kWh';
        $bill['meta']['Kilde for forbrugsdata'] = $source;

        $bill[self::ALL_TARIFFS] = 0;
        foreach (array_values($bill) as $value) {
            if (is_numeric($value)) {
                $bill[self::ALL_TARIFFS] = $bill[self::ALL_TARIFFS] + $value;
            }
        }


        $months = $this->getAllMonthsInRange($start_date, $end_date);

        $countOfAllDaysInMonhtsInvolved = 0;
        foreach($months as $month) {
            $countOfAllDaysInMonhtsInvolved = $countOfAllDaysInMonhtsInvolved + Carbon::createFromDate('2022',$month, 1)->daysInMonth;
        }

        foreach ($subscriptions as $subscription) {
            $bill[$subscription['name'].' (forholdsvis antal dage pr. måned, månedspris: '.round((count($months) * $subscription['price']) ,2).')'] = round((count($months) * $subscription['price']) * ($bill['meta']['Interval']['antal dage']/$countOfAllDaysInMonhtsInvolved),2);
        }


        $supplierSubscriptionDisplayText = 'Elabonnement (forholdsvis antal dage pr. måned, månedspris: ' . $subscription_at_elsupplier . ')';
        $bill[$supplierSubscriptionDisplayText] = count($months) * str_replace(',','.',$subscription_at_elsupplier) * ($bill['meta']['Interval']['antal dage']/$countOfAllDaysInMonhtsInvolved);
        $bill[$supplierSubscriptionDisplayText] = round($bill[$supplierSubscriptionDisplayText], 2);

        $bill['Moms'] = 0;
        foreach ($bill as $key => $value) {
            if($key== self::ALL_TARIFFS) {
                continue;
            }
            if (is_numeric($value)) {
                $bill['Moms'] = $bill['Moms'] + $value * 0.25;
            }
        }
        $bill['Moms'] = round($bill['Moms'], 2);

        $bill['Total'] = 0;
        foreach ($bill as $key => $value) {
            if($key== '' . self::ALL_TARIFFS . '') {
                continue;
            }
            if (is_numeric($value)) {
                $bill['Total'] = $bill['Total'] + $value;
            }
        }
        $bill['Total'] = round($bill['Total'], 2);

        if(array_key_exists('Spotpris',$bill) && $sum!=0) {
            $bill['Statistik']['Gennemsnitspris, strøm inkl. moms'] = round(($bill['Spotpris'] + $bill['Overhead'])*1.25/$sum, 2) . ' kr./kWh';
            $bill['Statistik']['Gennemsnitspris, alt tarifering inkl. moms'] = round(($bill[self::ALL_TARIFFS] * 1.25 )/$sum, 2) . ' kr./kWh';
            $bill['Statistik']['Gennemsnitspris, i alt (abonnementer indregnet) inkl. moms'] = round(($bill['Total'] )/$sum, 2) . ' kr./kWh';
        } else {
            $bill['Statistik']['Note'] = 'Der er endnu ikke forbrugsdata at indregne';
        }
        unset($bill[self::ALL_TARIFFS]);

        return $bill;
    }

    /**
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    private function getAllMonthsInRange(string $start_date, string $end_date): array
    {
        $start_month = Carbon::parse($start_date)->toDateString();
        $end_month = Carbon::parse($end_date)->subDay()->toDateString();
        $result = CarbonPeriod::create($start_month, $end_month);
        $months = array_values(collect($result)->map(function (Carbon $date) {
            return $date->format("m");
        })->unique()->toArray());
        return $months;
    }
}