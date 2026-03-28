<?php

namespace Tests\Services;

use App\Services\GetSpotPrices;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSpotPricesTest extends TestCase
{
    public const START_DATE = '2025-10-01';

    public const START_DATE_2 = '2022-10-31';

    public const END_DATE = '2025-10-02';

    public const END_DATE_2 = '2022-11-01';

    public const PRICE_AREA = 'DK2';

    private array $spotPricesDataSeres;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spotPricesDataSeres = $this->loadTestData(test_fixture_path('spot_prices_data_series.json'));
    }

    public function testGetData() : void
    {
        Http::fake([
            'api.energidataservice.dk/dataset/DayAheadPrices*' => Http::response($this->loadTestData(test_fixture_path('records.json')), 200)]);

        $getSpotPrices = new GetSpotPrices();
        $array = $getSpotPrices->getData(self::START_DATE, self::END_DATE, self::PRICE_AREA);
        $this->assertEquals($this->spotPricesDataSeres, $array);

        Http::assertSent(function (Request $request) {
            return $request->url(
            ) == 'https://api.energidataservice.dk/dataset/DayAheadPrices?start=' . self::START_DATE . '&end=' . self::END_DATE . '&filter=' . urlencode(
                '{"PriceArea":"' . self::PRICE_AREA . '"}'
            ) . '&columns=' . urlencode('TimeDK,DayAheadPriceDKK');
        });
        Http::assertSentCount(1);
    }

    /**
     * @throws \Exception
     */
    #[\PHPUnit\Framework\Attributes\Depends('testGetData')]
    public function testGetData2(): void
    {
        $response = [];

        $response['records'] = [
            [
                'TimeDK' => '2022-10-30T23:45:00+02:00',
                'DayAheadPriceDKK' => 1562.339966,
            ],
            [
                'TimeDK' => '2022-10-30T23:30:00+02:00',
                'DayAheadPriceDKK' => 1562.339966,
            ],
            [
                'TimeDK' => '2022-10-30T23:15:00+02:00',
                'DayAheadPriceDKK' => 1562.339966,
            ],
            [
                'TimeDK' => '2022-10-30T23:00:00+02:00',
                'DayAheadPriceDKK' => 1562.339966,
            ],
            [
                'TimeDK' => '2022-10-30T22:45:00+02:00',
                'DayAheadPriceDKK' => 1809.994965,
            ],
            [
                'TimeDK' => '2022-10-30T22:30:00+02:00',
                'DayAheadPriceDKK' => 2057.649964,
            ],
            [
                'TimeDK' => '2022-10-30T22:15:00+02:00',
                'DayAheadPriceDKK' => 2305.304962,
            ],
            [
                'TimeDK' => '2022-10-30T22:00:00+02:00',
                'DayAheadPriceDKK' => 2552.959961,
            ],
            [
                'TimeDK' => '2022-10-30T21:45:00+02:00',
                'DayAheadPriceDKK' => 2662.125,
            ],
            [
                'TimeDK' => '2022-10-30T21:30:00+02:00',
                'DayAheadPriceDKK' => 2771.290039,
            ],
            [
                'TimeDK' => '2022-10-30T21:15:00+02:00',
                'DayAheadPriceDKK' => 2880.455078,
            ],
            [
                'TimeDK' => '2022-10-30T21:00:00+02:00',
                'DayAheadPriceDKK' => 2989.620117,
            ],
            [
                'TimeDK' => '2022-10-30T20:45:00+02:00',
                'DayAheadPriceDKK' => 3288.797607,
            ],
            [
                'TimeDK' => '2022-10-30T20:30:00+02:00',
                'DayAheadPriceDKK' => 3587.975097,
            ],
            [
                'TimeDK' => '2022-10-30T20:15:00+02:00',
                'DayAheadPriceDKK' => 3887.152588,
            ],
            [
                'TimeDK' => '2022-10-30T20:00:00+02:00',
                'DayAheadPriceDKK' => 4186.330078,
            ],
            [
                'TimeDK' => '2022-10-30T19:45:00+02:00',
                'DayAheadPriceDKK' => 4207.677612,
            ],
            [
                'TimeDK' => '2022-10-30T19:30:00+02:00',
                'DayAheadPriceDKK' => 4229.025147,
            ],
            [
                'TimeDK' => '2022-10-30T19:15:00+02:00',
                'DayAheadPriceDKK' => 4250.372681,
            ],
            [
                'TimeDK' => '2022-10-30T19:00:00+02:00',
                'DayAheadPriceDKK' => 4271.720215,
            ],
            [
                'TimeDK' => '2022-10-30T18:45:00+02:00',
                'DayAheadPriceDKK' => 4226.647644,
            ],
            [
                'TimeDK' => '2022-10-30T18:30:00+02:00',
                'DayAheadPriceDKK' => 4181.575074,
            ],
            [
                'TimeDK' => '2022-10-30T18:15:00+02:00',
                'DayAheadPriceDKK' => 4136.502503,
            ],
            [
                'TimeDK' => '2022-10-30T18:00:00+02:00',
                'DayAheadPriceDKK' => 4091.429932,
            ],
            [
                'TimeDK' => '2022-10-30T17:45:00+02:00',
                'DayAheadPriceDKK' => 3978.544922,
            ],
            [
                'TimeDK' => '2022-10-30T17:30:00+02:00',
                'DayAheadPriceDKK' => 3865.659913,
            ],
            [
                'TimeDK' => '2022-10-30T17:15:00+02:00',
                'DayAheadPriceDKK' => 3752.774903,
            ],
            [
                'TimeDK' => '2022-10-30T17:00:00+02:00',
                'DayAheadPriceDKK' => 3639.889893,
            ],
            [
                'TimeDK' => '2022-10-30T16:45:00+02:00',
                'DayAheadPriceDKK' => 3413.30243,
            ],
            [
                'TimeDK' => '2022-10-30T16:30:00+02:00',
                'DayAheadPriceDKK' => 3186.714966,
            ],
            [
                'TimeDK' => '2022-10-30T16:15:00+02:00',
                'DayAheadPriceDKK' => 2960.127503,
            ],
            [
                'TimeDK' => '2022-10-30T16:00:00+02:00',
                'DayAheadPriceDKK' => 2733.540039,
            ],
            [
                'TimeDK' => '2022-10-30T15:45:00+02:00',
                'DayAheadPriceDKK' => 2626.532532,
            ],
            [
                'TimeDK' => '2022-10-30T15:30:00+02:00',
                'DayAheadPriceDKK' => 2519.525024,
            ],
            [
                'TimeDK' => '2022-10-30T15:15:00+02:00',
                'DayAheadPriceDKK' => 2412.517517,
            ],
            [
                'TimeDK' => '2022-10-30T15:00:00+02:00',
                'DayAheadPriceDKK' => 2305.51001,
            ],
            [
                'TimeDK' => '2022-10-30T14:45:00+02:00',
                'DayAheadPriceDKK' => 2219.960022,
            ],
            [
                'TimeDK' => '2022-10-30T14:30:00+02:00',
                'DayAheadPriceDKK' => 2134.410034,
            ],
            [
                'TimeDK' => '2022-10-30T14:15:00+02:00',
                'DayAheadPriceDKK' => 2048.860047,
            ],
            [
                'TimeDK' => '2022-10-30T14:00:00+02:00',
                'DayAheadPriceDKK' => 1963.310059,
            ],
            [
                'TimeDK' => '2022-10-30T13:45:00+02:00',
                'DayAheadPriceDKK' => 1959.962555,
            ],
            [
                'TimeDK' => '2022-10-30T13:30:00+02:00',
                'DayAheadPriceDKK' => 1956.615052,
            ],
            [
                'TimeDK' => '2022-10-30T13:15:00+02:00',
                'DayAheadPriceDKK' => 1953.267548,
            ],
            [
                'TimeDK' => '2022-10-30T13:00:00+02:00',
                'DayAheadPriceDKK' => 1949.920044,
            ],
            [
                'TimeDK' => '2022-10-30T12:45:00+02:00',
                'DayAheadPriceDKK' => 1988.612518,
            ],
            [
                'TimeDK' => '2022-10-30T12:30:00+02:00',
                'DayAheadPriceDKK' => 2027.304993,
            ],
            [
                'TimeDK' => '2022-10-30T12:15:00+02:00',
                'DayAheadPriceDKK' => 2065.997467,
            ],
            [
                'TimeDK' => '2022-10-30T12:00:00+02:00',
                'DayAheadPriceDKK' => 2104.689941,
            ],
            [
                'TimeDK' => '2022-10-30T11:45:00+02:00',
                'DayAheadPriceDKK' => 2348.607483,
            ],
            [
                'TimeDK' => '2022-10-30T11:30:00+02:00',
                'DayAheadPriceDKK' => 2592.525024,
            ],
            [
                'TimeDK' => '2022-10-30T11:15:00+02:00',
                'DayAheadPriceDKK' => 2836.442566,
            ],
            [
                'TimeDK' => '2022-10-30T11:00:00+02:00',
                'DayAheadPriceDKK' => 3080.360107,
            ],
            [
                'TimeDK' => '2022-10-30T10:45:00+02:00',
                'DayAheadPriceDKK' => 3235.377563,
            ],
            [
                'TimeDK' => '2022-10-30T10:30:00+02:00',
                'DayAheadPriceDKK' => 3390.395019,
            ],
            [
                'TimeDK' => '2022-10-30T10:15:00+02:00',
                'DayAheadPriceDKK' => 3545.412476,
            ],
            [
                'TimeDK' => '2022-10-30T10:00:00+02:00',
                'DayAheadPriceDKK' => 3700.429932,
            ],
            [
                'TimeDK' => '2022-10-30T09:45:00+02:00',
                'DayAheadPriceDKK' => 3760.602478,
            ],
            [
                'TimeDK' => '2022-10-30T09:30:00+02:00',
                'DayAheadPriceDKK' => 3820.775024,
            ],
            [
                'TimeDK' => '2022-10-30T09:15:00+02:00',
                'DayAheadPriceDKK' => 3880.947571,
            ],
            [
                'TimeDK' => '2022-10-30T09:00:00+02:00',
                'DayAheadPriceDKK' => 3941.120117,
            ],
            [
                'TimeDK' => '2022-10-30T08:45:00+02:00',
                'DayAheadPriceDKK' => 4037.957642,
            ],
            [
                'TimeDK' => '2022-10-30T08:30:00+02:00',
                'DayAheadPriceDKK' => 4134.795166,
            ],
            [
                'TimeDK' => '2022-10-30T08:15:00+02:00',
                'DayAheadPriceDKK' => 4231.632691,
            ],
            [
                'TimeDK' => '2022-10-30T08:00:00+02:00',
                'DayAheadPriceDKK' => 4328.470215,
            ],
            [
                'TimeDK' => '2022-10-30T07:45:00+02:00',
                'DayAheadPriceDKK' => 4298.960205,
            ],
            [
                'TimeDK' => '2022-10-30T07:30:00+02:00',
                'DayAheadPriceDKK' => 4269.450196,
            ],
            [
                'TimeDK' => '2022-10-30T07:15:00+02:00',
                'DayAheadPriceDKK' => 4239.940186,
            ],
            [
                'TimeDK' => '2022-10-30T07:00:00+02:00',
                'DayAheadPriceDKK' => 4210.430176,
            ],
            [
                'TimeDK' => '2022-10-30T06:45:00+02:00',
                'DayAheadPriceDKK' => 4147.172608,
            ],
            [
                'TimeDK' => '2022-10-30T06:30:00+02:00',
                'DayAheadPriceDKK' => 4083.915039,
            ],
            [
                'TimeDK' => '2022-10-30T06:15:00+02:00',
                'DayAheadPriceDKK' => 4020.657471,
            ],
            [
                'TimeDK' => '2022-10-30T06:00:00+02:00',
                'DayAheadPriceDKK' => 3957.399902,
            ],
            [
                'TimeDK' => '2022-10-30T05:45:00+02:00',
                'DayAheadPriceDKK' => 3796.264953,
            ],
            [
                'TimeDK' => '2022-10-30T05:30:00+02:00',
                'DayAheadPriceDKK' => 3635.130005,
            ],
            [
                'TimeDK' => '2022-10-30T05:15:00+02:00',
                'DayAheadPriceDKK' => 3473.995056,
            ],
            [
                'TimeDK' => '2022-10-30T05:00:00+02:00',
                'DayAheadPriceDKK' => 3312.860107,
            ],
            [
                'TimeDK' => '2022-10-30T04:45:00+02:00',
                'DayAheadPriceDKK' => 3213.027587,
            ],
            [
                'TimeDK' => '2022-10-30T04:30:00+02:00',
                'DayAheadPriceDKK' => 3113.195068,
            ],
            [
                'TimeDK' => '2022-10-30T04:15:00+02:00',
                'DayAheadPriceDKK' => 3013.362549,
            ],
            [
                'TimeDK' => '2022-10-30T04:00:00+02:00',
                'DayAheadPriceDKK' => 2913.530029,
            ],
            [
                'TimeDK' => '2022-10-30T03:45:00+02:00',
                'DayAheadPriceDKK' => 2859.515015,
            ],
            [
                'TimeDK' => '2022-10-30T03:30:00+02:00',
                'DayAheadPriceDKK' => 2805.5,
            ],
            [
                'TimeDK' => '2022-10-30T03:15:00+02:00',
                'DayAheadPriceDKK' => 2751.484986,
            ],
            [
                'TimeDK' => '2022-10-30T03:00:00+02:00',
                'DayAheadPriceDKK' => 2697.469971,
            ],
            [
                'TimeDK' => '2022-10-30T02:00:00+02:00',
                'DayAheadPriceDKK' => 2697.469971,
            ],
            [
                'TimeDK' => '2022-10-30T01:45:00+02:00',
                'DayAheadPriceDKK' => 2983.949951,
            ],
            [
                'TimeDK' => '2022-10-30T01:30:00+02:00',
                'DayAheadPriceDKK' => 3027.439942,
            ],
            [
                'TimeDK' => '2022-10-30T01:15:00+02:00',
                'DayAheadPriceDKK' => 3070.929932,
            ],
            [
                'TimeDK' => '2022-10-30T01:00:00+02:00',
                'DayAheadPriceDKK' => 3114.419922,
            ],
            [
                'TimeDK' => '2022-10-30T00:45:00+02:00',
                'DayAheadPriceDKK' => 3183.794922,
            ],
            [
                'TimeDK' => '2022-10-30T00:30:00+02:00',
                'DayAheadPriceDKK' => 3253.169922,
            ],
            [
                'TimeDK' => '2022-10-30T00:15:00+02:00',
                'DayAheadPriceDKK' => 3322.544922,
            ],
            [
                'TimeDK' => '2022-10-30T00:00:00+02:00',
                'DayAheadPriceDKK' => 3391.919922,
            ],
        ];

        Http::fake([
            'api.energidataservice.dk/dataset/DayAheadPrices*' => Http::response($response, 200)]);

        $getSpotPrices = new GetSpotPrices();

        $array = $getSpotPrices->getData(self::START_DATE_2, self::END_DATE_2, self::PRICE_AREA);

        $records = array_map(fn (array $record): array => $record, $response['records']);
        $expected = Arr::pluck(array_values($records), 'DayAheadPriceDKK', 'TimeDK');
        Arr::pull($expected, '2022-10-30T03:00:00+02:00');
        $this->assertEquals($expected, $array);

        Http::assertSent(function (Request $request) {
            return $request->url(
            ) == 'https://api.energidataservice.dk/dataset/DayAheadPrices?start=' . self::START_DATE_2 . '&end=' . self::END_DATE_2 . '&filter=' . urlencode(
                '{"PriceArea":"' . self::PRICE_AREA . '"}'
            ) . '&columns=' . urlencode('TimeDK,DayAheadPriceDKK');
        });
        Http::assertSentCount(1);
    }
}
