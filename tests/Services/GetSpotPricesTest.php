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
        $this->spotPricesDataSeres = $this->loadTestData(test_fixture_path('spot_prices_data_series.json'));
        parent::setUp();
    }

    public function testGetData()
    {
        Http::fake([
            'api.energidataservice.dk/dataset/Elspotprices*' => Http::response($this->loadTestData(test_fixture_path('records.json')), 200)]);

        $getSpotPrices = new GetSpotPrices();
        $array = $getSpotPrices->getData(self::START_DATE, self::END_DATE, self::PRICE_AREA);
        $this->assertEquals($this->spotPricesDataSeres, $array);

        Http::assertSent(function (Request $request) {
            return $request->url(
            ) == 'https://api.energidataservice.dk/dataset/Elspotprices?start=' . self::START_DATE . '&end=' . self::END_DATE . '&filter=' . urlencode(
                '{"PriceArea":"' . self::PRICE_AREA . '"}'
            ) . '&columns=' . urlencode('HourDK,SpotPriceDKK');
        });
        Http::assertSentCount(1);
    }

    /**
     * @depends('testGetData')
     * @return void
     * @throws \Exception
     */
    public function testGetData2()
    {
        $response = [];

        $response['records'] = [
            [
                'HourDK' => '2022-10-30T23:00:00+02:00',
                'SpotPriceDKK' => 1562.339966,
            ],
            [
                'HourDK' => '2022-10-30T22:00:00+02:00',
                'SpotPriceDKK' => 2552.959961,
            ],
            [
                'HourDK' => '2022-10-30T21:00:00+02:00',
                'SpotPriceDKK' => 2989.620117,
            ],
            [
                'HourDK' => '2022-10-30T20:00:00+02:00',
                'SpotPriceDKK' => 4186.330078,
            ],
            [
                'HourDK' => '2022-10-30T19:00:00+02:00',
                'SpotPriceDKK' => 4271.720215,
            ],
            [
                'HourDK' => '2022-10-30T18:00:00+02:00',
                'SpotPriceDKK' => 4091.429932,
            ],
            [
                'HourDK' => '2022-10-30T17:00:00+02:00',
                'SpotPriceDKK' => 3639.889893,
            ],
            [
                'HourDK' => '2022-10-30T16:00:00+02:00',
                'SpotPriceDKK' => 2733.540039,
            ],
            [
                'HourDK' => '2022-10-30T15:00:00+02:00',
                'SpotPriceDKK' => 2305.51001,
            ],
            [
                'HourDK' => '2022-10-30T14:00:00+02:00',
                'SpotPriceDKK' => 1963.310059,
            ],
            [
                'HourDK' => '2022-10-30T13:00:00+02:00',
                'SpotPriceDKK' => 1949.920044,
            ],
            [
                'HourDK' => '2022-10-30T12:00:00+02:00',
                'SpotPriceDKK' => 2104.689941,
            ],
            [
                'HourDK' => '2022-10-30T11:00:00+02:00',
                'SpotPriceDKK' => 3080.360107,
            ],
            [
                'HourDK' => '2022-10-30T10:00:00+02:00',
                'SpotPriceDKK' => 3700.429932,
            ],
            [
                'HourDK' => '2022-10-30T09:00:00+02:00',
                'SpotPriceDKK' => 3941.120117,
            ],
            [
                'HourDK' => '2022-10-30T08:00:00+02:00',
                'SpotPriceDKK' => 4328.470215,
            ],
            [
                'HourDK' => '2022-10-30T07:00:00+02:00',
                'SpotPriceDKK' => 4210.430176,
            ],
            [
                'HourDK' => '2022-10-30T06:00:00+02:00',
                'SpotPriceDKK' => 3957.399902,
            ],
            [
                'HourDK' => '2022-10-30T05:00:00+02:00',
                'SpotPriceDKK' => 3312.860107,
            ],
            [
                'HourDK' => '2022-10-30T04:00:00+02:00',
                'SpotPriceDKK' => 2913.530029,
            ],
            [
                'HourDK' => '2022-10-30T03:00:00+02:00',
                'SpotPriceDKK' => 2697.469971,
            ],
            [
                'HourDK' => '2022-10-30T02:00:00+02:00',
                'SpotPriceDKK' => 2697.469971,
            ],
            [
                'HourDK' => '2022-10-30T01:00:00+02:00',
                'SpotPriceDKK' => 3114.419922,
            ],
            [
                'HourDK' => '2022-10-30T00:00:00+02:00',
                'SpotPriceDKK' => 3391.919922,
            ],
        ];

        Http::fake([
            'api.energidataservice.dk/dataset/Elspotprices*' => Http::response($response, 200)]);

        $getSpotPrices = new GetSpotPrices();

        $array = $getSpotPrices->getData(self::START_DATE_2, self::END_DATE_2, self::PRICE_AREA);

        $expected = Arr::pluck(array_values($response['records']), 'SpotPriceDKK', 'HourDK');
        Arr::pull($expected, '2022-10-30T03:00:00+02:00');
        $this->assertEquals($expected, $array);

        Http::assertSent(function (Request $request) {
            return $request->url(
            ) == 'https://api.energidataservice.dk/dataset/Elspotprices?start=' . self::START_DATE_2 . '&end=' . self::END_DATE_2 . '&filter=' . urlencode(
                '{"PriceArea":"' . self::PRICE_AREA . '"}'
            ) . '&columns=' . urlencode('HourDK,SpotPriceDKK');
        });
        Http::assertSentCount(1);
    }
}
