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

    private mixed $spotPricesDataSeres;

    protected function setUp(): void
    {
        $this->spotPricesDataSeres = loadTestData(fixture_path('spot_prices_data_series.json'));
        parent::setUp();
        Http::fake([
            'api.energidataservice.dk/dataset/Elspotprices*'
            => Http::response($this->loadTestData(fixture_path('records.json')), 200)]);
    }

    public function testGetData()
    {
        $getSpotPrices = new GetSpotPrices();
        $array = $getSpotPrices->getData(self::START_DATE, self::END_DATE, self::PRICE_AREA);
        $this->assertEquals($this->spotPricesDataSeres, $array);

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api.energidataservice.dk/dataset/Elspotprices?start=' . self::START_DATE . '&end=' . self::END_DATE . '&filter=' . urlencode('{"PriceArea":"' . self::PRICE_AREA . '"}') . '&columns=' . urlencode('HourDK,SpotPriceDKK');
        });
        Http::assertSentCount(1);
    }
}
