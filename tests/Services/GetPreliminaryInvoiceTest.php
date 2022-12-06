<?php

namespace Tests\Services;

use App\Services\GetMeteringData;
use App\Services\GetPreliminaryInvoice;
use App\Services\GetSpotPrices;
use Mockery\MockInterface;
use Tests\TestCase;

class GetPreliminaryInvoiceTest extends TestCase
{

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

    const CHARGES = [
        [
            [
                "price" => 21,
                "quantity" => 1,
                "name" => "Netabo C forbrug skabelon/flex",
                "description" => "Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en årsaflæst måler",
                "owner" => "5790000705689",
                "validFromDate" => "2015-05-31T22:00:00.000Z",
                "validToDate" => null,
                "periodType" => "P1M"
            ]
        ],
        [
            [
                "prices" => [
                    [
                        "position" => "1",
                        "price" => 0.049
                    ]
                ],
                "name" => "Transmissions nettarif",
                "description" => "Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.",
                "owner" => "5790000432752",
                "validFromDate" => "2014-12-31T23:00:00.000Z",
                "validToDate" => null,
                "periodType" => "P1D"
            ],
            [
                "prices" => [
                    [
                        "position" => "1",
                        "price" => 0.061
                    ]
                ],
                "name" => "Systemtarif",
                "description" => "Systemafgiften dækker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.",
                "owner" => "5790000432752",
                "validFromDate" => "2014-12-31T23:00:00.000Z",
                "validToDate" => null,
                "periodType" => "P1D"
            ],
            [
                "prices" => [
                    [
                        "position" => "1",
                        "price" => 0.00229
                    ]
                ],
                "name" => "Balancetarif for forbrug",
                "description" => "Balancetarif for forbrug",
                "owner" => "5790000432752",
                "validFromDate" => "2014-12-31T23:00:00.000Z",
                "validToDate" => "2022-12-31T23:00:00.000Z",
                "periodType" => "P1D"
            ],
            [
                "prices" => [
                    [
                        "position" => "1",
                        "price" => 0.723
                    ]
                ],
                "name" => "Elafgift",
                "description" => "Elafgiften",
                "owner" => "5790000432752",
                "validFromDate" => "2015-05-31T22:00:00.000Z",
                "validToDate" => null,
                "periodType" => "P1D"
            ],
            [
                "prices" => [
                    [
                        "position" => "1",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "2",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "3",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "4",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "5",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "6",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "7",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "8",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "9",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "10",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "11",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "12",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "13",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "14",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "15",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "16",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "17",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "18",
                        "price" => 0.7651
                    ],
                    [
                        "position" => "19",
                        "price" => 0.7651
                    ],
                    [
                        "position" => "20",
                        "price" => 0.7651
                    ],
                    [
                        "position" => "21",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "22",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "23",
                        "price" => 0.3003
                    ],
                    [
                        "position" => "24",
                        "price" => 0.3003
                    ]
                ],
                "name" => "Nettarif C time",
                "description" => "Nettarif C time",
                "owner" => "5790000705689",
                "validFromDate" => "2019-04-30T22:00:00.000Z",
                "validToDate" => null,
                "periodType" => "PT1H"
            ]
        ]
    ];

    const TEST_SPOTPRICES = [
        "2022-10-01T00:00:00+02:00" => 478.950012,
        "2022-10-01T01:00:00+02:00" => 472.850006,
        "2022-10-01T02:00:00+02:00" => 371.799988,
        "2022-10-01T03:00:00+02:00" => 159.720001,
        "2022-10-01T04:00:00+02:00" => 125.739998,
        "2022-10-01T05:00:00+02:00" => 111.760002,
        "2022-10-01T06:00:00+02:00" => 111.690002,
        "2022-10-01T07:00:00+02:00" => 177.270004,
        "2022-10-01T08:00:00+02:00" => 334.769989,
        "2022-10-01T09:00:00+02:00" => 543.200012,
        "2022-10-01T10:00:00+02:00" => 816.840027,
        "2022-10-01T11:00:00+02:00" => 793.940002,
        "2022-10-01T12:00:00+02:00" => 669.23999,
        "2022-10-01T13:00:00+02:00" => 550.559998,
        "2022-10-01T14:00:00+02:00" => 491.959991,
        "2022-10-01T15:00:00+02:00" => 497.470001,
        "2022-10-01T16:00:00+02:00" => 519.179993,
        "2022-10-01T17:00:00+02:00" => 1024.670044,
        "2022-10-01T18:00:00+02:00" => 1259.060059,
        "2022-10-01T19:00:00+02:00" => 1455.73999,
        "2022-10-01T20:00:00+02:00" => 1340.47998,
        "2022-10-01T21:00:00+02:00" => 1077.469971,
        "2022-10-01T22:00:00+02:00" => 820.109985,
        "2022-10-01T23:00:00+02:00" => 575.909973,
    ];

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
                ->andReturn(self::TEST_DATA);
            $mock
                ->shouldReceive('getCharges')
                ->once()
                ->andReturn(self::CHARGES);
        });

        $this->mock(GetSpotPrices::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getData')
                ->once()
                ->andReturn(self::TEST_SPOTPRICES);
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
