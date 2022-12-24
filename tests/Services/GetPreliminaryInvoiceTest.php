<?php

namespace Tests\Services;

use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\GetSpotPrices;
use Mockery\MockInterface;
use Tests\TestCase;

class GetPreliminaryInvoiceTest extends TestCase
{

    //Consumption is normally returned from the service as an array with {date_time=>usage}
    //So a key with 00:00 means the usage between 00:00 and 01:00
    const TEST_DATA = [
        "2022-10-01T00:00:00+02:00" => "1.39",
        "2022-10-01T01:00:00+02:00" => "1.23",
        "2022-10-01T02:00:00+02:00" => "4.15",
        "2022-10-01T03:00:00+02:00" => "4.22",
        "2022-10-01T04:00:00+02:00" => "4.17",
        "2022-10-01T05:00:00+02:00" => "4.2",
        "2022-10-01T06:00:00+02:00" => "3.85",
        "2022-10-01T07:00:00+02:00" => "1.58",
        "2022-10-01T08:00:00+02:00" => "1.65",
        "2022-10-01T09:00:00+02:00" => "0.88",
        "2022-10-01T10:00:00+02:00" => "0.4",
        "2022-10-01T11:00:00+02:00" => "0.48",
        "2022-10-01T12:00:00+02:00" => "0.52",
        "2022-10-01T13:00:00+02:00" => "0.66",
        "2022-10-01T14:00:00+02:00" => "0.49",
        "2022-10-01T15:00:00+02:00" => "0.6",
        "2022-10-01T16:00:00+02:00" => "0.45",
        "2022-10-01T17:00:00+02:00" => "0.39",
        "2022-10-01T18:00:00+02:00" => "0.4",
        "2022-10-01T19:00:00+02:00" => "0.41",
        "2022-10-01T20:00:00+02:00" => "0.41",
        "2022-10-01T21:00:00+02:00" => "0.39",
        "2022-10-01T22:00:00+02:00" => "0.39",
        "2022-10-01T23:00:00+02:00" => "0.37",
        ];

    private $charges;
    private mixed $spotPrices;
    private mixed $testConsumptions;


    protected function setUp(): void
    {
        require_once 'tests/helpers.php';

        //Got hold of some real charges and decided to use them here - not so important anyway what the values are
        //but we need a reliable datastructure.
        $this->charges = loadTestData(fixture_path('typical_charges.json'));
        $this->spotPrices = loadTestData(fixture_path('spot_prices.json'));
        $this->testConsumptions = loadTestData(fixture_path('consumption_data.json'));


        parent::setUp();
    }

    /**
     * Goal here is to check that the calculations can be performed on the expected datastructes.
     * Won't test the actual data/data-structures from providers - this is should be done in
     * other test (and is also important)
     *
     * @throws \App\Exceptions\DataUnavailableException
     * @throws \Tvup\ElOverblikApi\ElOverblikApiException
     * @throws \Tvup\EwiiApi\EwiiApiException
     */
    public function testGetBill()
    {
        $this->mock(GetMeteringData::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getData')
                ->once()
                ->andReturn($this->testConsumptions);
            $mock
                ->shouldReceive('getCharges')
                ->once()
                ->andReturn($this->charges);
        });

        $this->mock(GetSpotPrices::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getData')
                ->once()
                ->andReturn($this->spotPrices);
        });

        $expectedResult = [
            'meta' =>
                [
                    'Interval' =>
                        [
                            'fra' =>
                                "2022-10-01",
                            'til' =>
                                "2022-10-02",
                            'antal dage' =>
                                1,
                            'antal timer i intervallet' =>
                                24,
                        ],
                    'Forbrug' =>
                        "33.68 kWh",
                    'Kilde for forbrugsdata' =>
                        "DATAHUB",
                ],
            'Transmissions nettarif' => 1.65,
            'Systemtarif' => 2.04,
            'Balancetarif for forbrug' => 0.05,
            'Elafgift' => 24.35,
            'Nettarif C time' => 10.69,
            'Spotpris' => 11.38,
            'Overhead' => 0.53,
            'Netabo C forbrug skabelon/flex (forholdsvis antal dage pr. måned, månedspris: 21)' => 0.68,
            'Elabonnement (forholdsvis antal dage pr. måned, månedspris: 23.2)' => 0.75,
            'Moms' => 13.03,
            'Total' => 65.15,
            'Statistik' =>
                [
                    'Gennemsnitspris, strøm inkl. moms' => "0.44 kr./kWh",
                    'Gennemsnitspris, alt tarifering inkl. moms' => "1.88 kr./kWh",
                    'Gennemsnitspris, i alt (abonnementer indregnet) inkl. moms' => "1.93 kr./kWh",
                ]
        ];

        $preLiminaryInvoice = app(GetPreliminaryInvoice::class);
        $start_date = '2022-10-01';
        $end_date = '2022-10-02';
        $price_area = 'DK2';
        $smartMeCredentials = null;
        $dataSource = null; //At moment of writing this defaults to 'Datahub'
        $refreshToken = 'someFakeRefreshToken'; //Won't be used because we're mocking the service that contacts datahub
        //Only six parameters are needed here, the rest has defaults. We'll test the simple one for now
        $returnArray = $preLiminaryInvoice->getBill($start_date, $end_date, $price_area, $smartMeCredentials, $dataSource, $refreshToken);
        $this->assertEquals($expectedResult,$returnArray);
    }
}
