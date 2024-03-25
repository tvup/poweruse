<?php

namespace Tests\Http\Controllers\TotalPrices;

use App\Actions\ElectricityPrices\RetrieveSpotPrices;
use App\Actions\ElectricityPrices\RetrieveTariffFromOperator;
use App\Models\DatahubPriceList;
use App\Models\User;
use App\Services\GetDatahubPriceLists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;

class ProcessControllerTest extends TestCase
{
    public function testInvoke()
    {
        $d1 = DatahubPriceList::factory()->create(['Note'=>'Note', 'ChargeOwner' => 'Energinet Systemansvar A/S (SYO)', 'deleted_at'=> null]);
        $d2 = DatahubPriceList::factory()->create(['Note'=>'Note', 'ChargeOwner' => 'Company', 'ValidFrom' => now()->subDay(), 'ValidTo'=> null, 'deleted_at'=> null]);

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

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

        // Mock Request
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')->with('area')->andReturn('DK1');
        $request->shouldReceive('input')->with('netcompany')->andReturn('Company//Note');
        $request->shouldReceive('input')->with('outputformat')->andReturn('JSON');
        $request->shouldReceive('all')->andReturn('JSON');
        $request->shouldReceive('route')->andReturn('Company//Note');

        // Mock Actions
        $getDatahubPriceLists = Mockery::mock(GetDatahubPriceLists::class);
        $getDatahubPriceLists->shouldReceive('requestDatahubPriceListsFromEnergiDataService')->andReturn($dhlistprice);

        $mockSpotPrices = Mockery::mock(RetrieveSpotPrices::class);
        $mockSpotPrices->shouldReceive('handle')->andReturn([1=>10.0, 2=>20.0, 3=>30.0, 4 => 30.0, 5 => 30.0, 6 => 30.0, 7 => 30.0, 8 => 30.0, 9 => 30.0, 10 => 30.0, 11 => 30.0, 12 => 30.0, 13 => 30.0, 14 => 30.0, 15 => 30.0, 16 => 30.0, 17 => 30.0, 18 => 30.0, 19 => 30.0, 20 => 30.0, 21 => 30.0, 22 => 30.0, 23 => 30.0]); // Giv nogle ikke-tomme priser

        $mockRetrieveTariffFromOperator = Mockery::mock(RetrieveTariffFromOperator::class);
        $mockRetrieveTariffFromOperator->shouldReceive('handle')->andReturn([4, 5, 6]); // Mock return data

        $this->app->instance(GetDatahubPriceLists::class, $getDatahubPriceLists);
        $this->app->instance(RetrieveSpotPrices::class, $mockSpotPrices);
        $this->app->instance(RetrieveTariffFromOperator::class, $mockRetrieveTariffFromOperator);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession($sessionData)->post('/totalprices', [
            'area'=>'DK1',
            'netcompany'=>'Company//Note',
            'outputformat'=>'JSON',
        ]);

        $response->assertRedirect('/totalprices');

        // Assert session has specific keys
        foreach ($sessionData as $key => $value) {
            $this->assertSessionHas($key, $value);
        }
    }

    protected function assertSessionHas($key)
    {
        // Check if session has a specific key
        $this->assertTrue(Session::has($key), "Session does not contain expected key '{$key}'");
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
