<?php

namespace Tests\Http\Controllers;

use App\Models\Operator;
use App\Services\GetDatahubPriceLists;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class ElControllerTest extends TestCase
{
    use WithoutMiddleware; // Brug denne trait, hvis du vil ignorere middleware under testen.

    /** @test */
    public function test_it_returns_total_price_for_today()
    {
        $dhlistprice = [[
            'ChargeOwner' => 'Energinet Systemansvar A/S (SYO)',
            'GLN_Number' => '5790000432752',
            'ChargeType' => 'D03',
            'ChargeTypeCode' => '40000',
            'Note' => 'Transmissions nettarif',
            'Description' => 'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.',
            'ValidFrom' => '2023-09-30T00:00:00',
            'ValidTo' => '2024-01-01T00:00:00',
            'VATClass' => 'D02',
            'Price1' => 0.058,
            'Price2' => null,
            'Price3' => null,
            'Price4' => null,
            'Price5' => null,
            'Price6' => null,
            'Price7' => null,
            'Price8' => null,
            'Price9' => null,
            'Price10' => null,
            'Price11' => null,
            'Price12' => null,
            'Price13' => null,
            'Price14' => null,
            'Price15' => null,
            'Price16' => null,
            'Price17' => null,
            'Price18' => null,
            'Price19' => null,
            'Price20' => null,
            'Price21' => null,
            'Price22' => null,
            'Price23' => null,
            'Price24' => null,
            'TransparentInvoicing' => 0,
            'TaxIndicator' => 0,
            'ResolutionDuration' => 'P1D',
        ], ];

        // Mock dine metoder her
        $getDatahubPriceLists = Mockery::mock(GetDatahubPriceLists::class);
        $getDatahubPriceLists->shouldReceive('requestDatahubPriceListsFromEnergiDataService')->andReturn($dhlistprice);
        $this->app->instance(GetDatahubPriceLists::class, $getDatahubPriceLists);

        $glnNumber = 5790000705689;
        Operator::$operatorName = [$glnNumber => 'Radius Elnet A/S'];
        Operator::$gridOperatorArea = ['Radius Elnet A/S' => 'DK2'];

        // Opsæt data for testen
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 14, 0, 0)); // Simulerer nuværende tid til kl. 14:00

        // Lav et API-kald til din metode
        $response = $this->json('GET', '/api/el/totalprice/' . $glnNumber);

        // Bekræft, at dit svar indeholder forventede data
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    'data' => [
                        '*' => [
                            'time',
                            'price',
                        ],
                    ],
                ],
            ]);

        // Tilføj flere assertions her baseret på din applikations logik.
    }
}
