<?php

namespace Tests\Services;

use App\Services\GetSpotPrices;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSpotPricesTest extends TestCase
{
    public const START_DATE = '2022-09-02';

    public const START_DATE_2 = '2022-10-31';

    public const END_DATE = '2022-09-03';

    public const END_DATE_2 = '2022-11-01';

    public const PRICE_AREA = 'DK2';

    private array $spotPricesDataSeres;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spotPricesDataSeres = $this->loadTestData(test_fixture_path('spot_prices_data_series.json'));
    }

    public function testGetData(): void
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
                'TimeDK' => '2022-10-30T23:00:00+02:00',
                'DayAheadPriceDKK' => 1562.339966,
            ],
            [
                'TimeDK' => '2022-10-30T22:00:00+02:00',
                'DayAheadPriceDKK' => 2552.959961,
            ],
            [
                'TimeDK' => '2022-10-30T21:00:00+02:00',
                'DayAheadPriceDKK' => 2989.620117,
            ],
            [
                'TimeDK' => '2022-10-30T20:00:00+02:00',
                'DayAheadPriceDKK' => 4186.330078,
            ],
            [
                'TimeDK' => '2022-10-30T19:00:00+02:00',
                'DayAheadPriceDKK' => 4271.720215,
            ],
            [
                'TimeDK' => '2022-10-30T18:00:00+02:00',
                'DayAheadPriceDKK' => 4091.429932,
            ],
            [
                'TimeDK' => '2022-10-30T17:00:00+02:00',
                'DayAheadPriceDKK' => 3639.889893,
            ],
            [
                'TimeDK' => '2022-10-30T16:00:00+02:00',
                'DayAheadPriceDKK' => 2733.540039,
            ],
            [
                'TimeDK' => '2022-10-30T15:00:00+02:00',
                'DayAheadPriceDKK' => 2305.51001,
            ],
            [
                'TimeDK' => '2022-10-30T14:00:00+02:00',
                'DayAheadPriceDKK' => 1963.310059,
            ],
            [
                'TimeDK' => '2022-10-30T13:00:00+02:00',
                'DayAheadPriceDKK' => 1949.920044,
            ],
            [
                'TimeDK' => '2022-10-30T12:00:00+02:00',
                'DayAheadPriceDKK' => 2104.689941,
            ],
            [
                'TimeDK' => '2022-10-30T11:00:00+02:00',
                'DayAheadPriceDKK' => 3080.360107,
            ],
            [
                'TimeDK' => '2022-10-30T10:00:00+02:00',
                'DayAheadPriceDKK' => 3700.429932,
            ],
            [
                'TimeDK' => '2022-10-30T09:00:00+02:00',
                'DayAheadPriceDKK' => 3941.120117,
            ],
            [
                'TimeDK' => '2022-10-30T08:00:00+02:00',
                'DayAheadPriceDKK' => 4328.470215,
            ],
            [
                'TimeDK' => '2022-10-30T07:00:00+02:00',
                'DayAheadPriceDKK' => 4210.430176,
            ],
            [
                'TimeDK' => '2022-10-30T06:00:00+02:00',
                'DayAheadPriceDKK' => 3957.399902,
            ],
            [
                'TimeDK' => '2022-10-30T05:00:00+02:00',
                'DayAheadPriceDKK' => 3312.860107,
            ],
            [
                'TimeDK' => '2022-10-30T04:00:00+02:00',
                'DayAheadPriceDKK' => 2913.530029,
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
                'TimeDK' => '2022-10-30T01:00:00+02:00',
                'DayAheadPriceDKK' => 3114.419922,
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

        $expected = Arr::pluck($response['records'], 'DayAheadPriceDKK', 'TimeDK');
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
