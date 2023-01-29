<?php

namespace Tests\Services;

use App\Services\GetSpotPrices;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetSpotPricesTest extends TestCase
{
    public const START_DATE = '2022-09-02';

    public const END_DATE = '2022-09-03';

    public const PRICE_AREA = 'DK2';

    private array $spotPricesDataSeres;

    protected function setUp(): void
    {
        $this->spotPricesDataSeres = $this->loadTestData(test_fixture_path('spot_prices_data_series.json'));
        parent::setUp();
        Http::fake([
            'api.energidataservice.dk/dataset/Elspotprices*' => Http::response($this->loadTestData(test_fixture_path('records.json')), 200)]);
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
