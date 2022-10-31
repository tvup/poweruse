<?php

namespace Tests\Services;

use App\Services\GetSpotPrices;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSpotPricesTest extends TestCase
{
    const START_DATE = '2022-09-02';
    const END_DATE = '2022-09-03';
    const PRICE_AREA = 'DK2';
    const SPOT_PRICES_DATA_SERIES = array('2022-09-02T00:00:00+02:00' => 3391.919922,
        '2022-09-02T01:00:00+02:00' => 3114.419922,
        '2022-09-02T02:00:00+02:00' => 2940.459961,
        '2022-09-02T03:00:00+02:00' => 2697.469971,
        '2022-09-02T04:00:00+02:00' => 2913.530029,
        '2022-09-02T05:00:00+02:00' => 3312.860107,
        '2022-09-02T06:00:00+02:00' => 3957.399902,
        '2022-09-02T07:00:00+02:00' => 4210.430176,
        '2022-09-02T08:00:00+02:00' => 4328.470215,
        '2022-09-02T09:00:00+02:00' => 3941.120117,
        '2022-09-02T10:00:00+02:00' => 3700.429932,
        '2022-09-02T11:00:00+02:00' => 3080.360107,
        '2022-09-02T12:00:00+02:00' => 2104.689941,
        '2022-09-02T13:00:00+02:00' => 1949.920044,
        '2022-09-02T14:00:00+02:00' => 1963.310059,
        '2022-09-02T15:00:00+02:00' => 2305.51001,
        '2022-09-02T16:00:00+02:00' => 2733.540039,
        '2022-09-02T17:00:00+02:00' => 3639.889893,
        '2022-09-02T18:00:00+02:00' => 4091.429932,
        '2022-09-02T19:00:00+02:00' => 4271.720215,
        '2022-09-02T20:00:00+02:00' => 4186.330078,
        '2022-09-02T21:00:00+02:00' => 2989.620117,
        '2022-09-02T22:00:00+02:00' => 2552.959961,
        '2022-09-02T23:00:00+02:00' => 1562.339966);

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            'api.energidataservice.dk/dataset/Elspotprices?start=' . self::START_DATE . '&end=' . self::END_DATE . '&filter={"PriceArea":"' . self::PRICE_AREA . '"}&columns=HourDK,SpotPriceDKK'
            => Http::response(['records' => [
                ['HourDK' => '2022-09-02T23:00:00+02:00', 'SpotPriceDKK' => 1562.339966],
                ['HourDK' => '2022-09-02T22:00:00+02:00', 'SpotPriceDKK' => 2552.959961],
                ['HourDK' => '2022-09-02T21:00:00+02:00', 'SpotPriceDKK' => 2989.620117],
                ['HourDK' => '2022-09-02T20:00:00+02:00', 'SpotPriceDKK' => 4186.330078],
                ['HourDK' => '2022-09-02T19:00:00+02:00', 'SpotPriceDKK' => 4271.720215],
                ['HourDK' => '2022-09-02T18:00:00+02:00', 'SpotPriceDKK' => 4091.429932],
                ['HourDK' => '2022-09-02T17:00:00+02:00', 'SpotPriceDKK' => 3639.889893],
                ['HourDK' => '2022-09-02T16:00:00+02:00', 'SpotPriceDKK' => 2733.540039],
                ['HourDK' => '2022-09-02T15:00:00+02:00', 'SpotPriceDKK' => 2305.51001],
                ['HourDK' => '2022-09-02T14:00:00+02:00', 'SpotPriceDKK' => 1963.310059],
                ['HourDK' => '2022-09-02T13:00:00+02:00', 'SpotPriceDKK' => 1949.920044],
                ['HourDK' => '2022-09-02T12:00:00+02:00', 'SpotPriceDKK' => 2104.689941],
                ['HourDK' => '2022-09-02T11:00:00+02:00', 'SpotPriceDKK' => 3080.360107],
                ['HourDK' => '2022-09-02T10:00:00+02:00', 'SpotPriceDKK' => 3700.429932],
                ['HourDK' => '2022-09-02T09:00:00+02:00', 'SpotPriceDKK' => 3941.120117],
                ['HourDK' => '2022-09-02T08:00:00+02:00', 'SpotPriceDKK' => 4328.470215],
                ['HourDK' => '2022-09-02T07:00:00+02:00', 'SpotPriceDKK' => 4210.430176],
                ['HourDK' => '2022-09-02T06:00:00+02:00', 'SpotPriceDKK' => 3957.399902],
                ['HourDK' => '2022-09-02T05:00:00+02:00', 'SpotPriceDKK' => 3312.860107],
                ['HourDK' => '2022-09-02T04:00:00+02:00', 'SpotPriceDKK' => 2913.530029],
                ['HourDK' => '2022-09-02T03:00:00+02:00', 'SpotPriceDKK' => 2697.469971],
                ['HourDK' => '2022-09-02T02:00:00+02:00', 'SpotPriceDKK' => 2940.459961],
                ['HourDK' => '2022-09-02T01:00:00+02:00', 'SpotPriceDKK' => 3114.419922],
                ['HourDK' => '2022-09-02T00:00:00+02:00', 'SpotPriceDKK' => 3391.919922],
            ]
            ], 200)]);
    }

    public function testGetData()
    {
        $getSpotPrices = new GetSpotPrices();
        $array = $getSpotPrices->getData(self::START_DATE, self::END_DATE, self::PRICE_AREA);
        $this->assertEquals(self::SPOT_PRICES_DATA_SERIES, $array);

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api.energidataservice.dk/dataset/Elspotprices?start=' . self::START_DATE . '&end=' . self::END_DATE . '&filter=' . urlencode('{"PriceArea":"' . self::PRICE_AREA . '"}') . '&columns=' . urlencode('HourDK,SpotPriceDKK');
        });
        Http::assertSentCount(1);
    }
}
