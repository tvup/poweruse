<?php

namespace Tests\Http\Controllers\TotalPrices;

use App\Actions\ElectricityPrices\RetrieveSpotPrices;
use App\Actions\ElectricityPrices\RetrieveTariffFromOperator;
use App\Models\DatahubPriceList;
use App\Models\User;
use App\Services\GetDatahubPriceLists;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;

class ProcessControllerTest extends TestCase
{
    /**
     * Happy-paths BEGIN.
     */
    use RefreshDatabase;

    public function test_invoke_at_midnight() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 0, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->andReturn($this->getTodaySpotPrices());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 96;
        });
    }

    public function test_invoke_before_1pm() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 11, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->andReturn($this->getTodaySpotPrices());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 52;
        });
    }

    public function test_invoke_after_1pm() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPrices());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn(
            $this->getTommorwSpotPrices()
        );

        $mockRetrieveTariffFromOperator = Mockery::mock(RetrieveTariffFromOperator::class);
        $mockRetrieveTariffFromOperator->shouldReceive('handle')->andReturn([0, 0, 0]); // Mock return data

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 136 && $value['2023-01-01 14:00:00+01:00'] == 39.09 && $value['2023-01-02 00:00:00+01:00'] == 39.19;
        });
    }

    /**
     * Happy-paths END.
     */

    /**
     * Cases with empty spot-prices BEGIN.
     */
    public function test_invoke_before_1pm_but_spot_prices_cant_be_provided() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 11, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->andReturn([]);

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('error', function ($value) {
            return $value == 'It wasn\'t possible to get today\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
        });
    }

    public function test_invoke_after_1pm_but_tomorrows_spot_prices_cant_be_provided() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPrices());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn([]);

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('warning', function ($value) {
            return $value == 'It wasn\'t possible to get tomorrow\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
        });

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 40 && $value['2023-01-01 14:00:00+01:00'] == 39.09;
        });
    }

    /**
     * Cases with empty spot-prices END.
     */

    /**
     * Edge cases BEGIN.
     */
    public function test_invoke_before_1pm_dst_early_is_today() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 3, 26, 1, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->andReturn($this->getTodaySpotPricesEarlyDst());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 88;
        });
    }

    public function test_invoke_after_1pm_dst_early_is_today() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 3, 26, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPricesEarlyDst());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn($this->getTommorwSpotPrices());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 132 && $value['2023-03-26 16:00:00+02:00'] == 39.1 && $value['2023-03-27 00:00:00+02:00'] == 39.19;
        });
    }

    public function test_invoke_after_1pm_dst_early_is_tomorrow() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 3, 25, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPrices());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn($this->getTommorwSpotPricesEarlyDst());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 132 && $value['2023-03-25 15:00:00+01:00'] == 39.1 && $value['2023-03-26 00:00:00+01:00'] == 39.19;
        });
    }

    public function test_invoke_before_1pm_dst_late_is_today() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 10, 29, 1, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->andReturn($this->getTodaySpotPricesLateDst());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 96;
        });
    }

    public function test_invoke_after_1pm_dst_late_is_today() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 10, 29, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPricesLateDst());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn($this->getTommorwSpotPrices());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 140 && $value['2023-10-29 15:00:00+01:00'] == 39.35 && $value['2023-10-30 00:00:00+01:00'] == 39.19;
        });
    }

    public function test_invoke_after_1pm_dst_late_is_tomorrow() : void
    {
        Carbon::setTestNow(Carbon::create(2023, 10, 28, 14, 0, 0, 'Europe/Copenhagen'));

        $this->createDatahubPriceListTestData();

        $sessionData = [
            'status' => 'status',
            'data' => 'data',
            //'chart' => 'chart',
            'companies' => 'companies',
            'netcompany' => 'netcompany',
        ];

        $dhlistprice = $this->getDhlistprice();

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
        $mockSpotPrices->shouldReceive('handle')->with('DK1')->once()->andReturn($this->getTodaySpotPrices());
        $mockSpotPrices->shouldReceive('handle')->with('DK1', Mockery::type(\Carbon\Carbon::class))->once()->andReturn($this->getTommorwSpotPricesLateDst());

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
            $this->assertSessionHas($key);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 140 && $value['2023-10-28 15:00:00+02:00'] == 39.1 && $value['2023-10-29 00:00:00+02:00'] == 39.19;
        });
    }

    protected function assertSessionHas(string $key) : void
    {
        // Check if session has a specific key
        $this->assertTrue(Session::has($key), "Session does not contain expected key '{$key}'");
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function createDatahubPriceListTestData(): void
    {
        DatahubPriceList::create([
            'ChargeOwner' => 'Company',
            'GLN_Number' => '',
            'ChargeType' => '',
            'ChargeTypeCode' => '',
            'Note' => 'Note',
            'Description' => 'Description2',
            'ValidFrom' => now()->subDay(),
            'ValidTo' => null,
            'VATClass' => 'D02',
            'Price1' =>  1,
            'Price2' =>  1,
            'Price3' =>  1,
            'Price4' =>  1,
            'Price5' =>  1,
            'Price6' =>  1,
            'Price7' =>  1,
            'Price8' =>  1,
            'Price9' =>  1,
            'Price10' => 1,
            'Price11' => 1,
            'Price12' => 1,
            'Price13' => 1,
            'Price14' => 1,
            'Price15' => 1,
            'Price16' => 1,
            'Price17' => 1,
            'Price18' => 1,
            'Price19' => 1,
            'Price20' => 1,
            'Price21' => 1,
            'Price22' => 1,
            'Price23' => 1,
            'Price24' => 1,
            'TransparentInvoicing' => 0,
            'TaxIndicator' => 0,
            'ResolutionDuration' => 'P1H',
        ]);
    }

    /**
     * @return array[]
     */
    public function getDhlistprice(): array
    {
        $dhlistprice = [
            [
                'ChargeOwner' => 'Energinet Systemansvar A/S (SYO)',
                'GLN_Number' => '5790000432752',
                'ChargeType' => 'D03',
                'ChargeTypeCode' => '40000',
                'Note' => 'Transmissions nettarif',
                'Description' => 'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.',
                'ValidFrom' => '2023-09-30T00:00:00',
                'ValidTo' => '2024-01-01T00:00:00',
                'VATClass' => 'D02',
                'Price1' => 10,
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
            ],
        ];

        return $dhlistprice;
    }

    /**
     * @return array
     */
    public function getTodaySpotPrices(): array
    {
        $hourlyPrices = [160, 168.0, 176.0, 184, 192.0, 200.0, 208.0, 216.0, 224.0, 232.0, 240.0, 248.0, 256.0, 264.0, 272.0, 280.0, 288.0, 296.0, 304.0, 312.0, 320.0, 328.0, 336.0, 344.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }

    /**
     * @return float[]
     */
    public function getTommorwSpotPrices(): array
    {
        $hourlyPrices = [352.0, 360.0, 368.0, 376.0, 384.0, 392.0, 400.0, 408.0, 416.0, 424.0, 432.0, 440.0, 448.0, 456.0, 464.0, 472.0, 480.0, 488.0, 496.0, 504.0, 512.0, 520.0, 528.0, 536.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }

    /**
     * @return array
     */
    public function getTodaySpotPricesEarlyDst(): array
    {
        // 23 hours = 92 quarters (DST spring forward loses 1 hour)
        $hourlyPrices = [160, 168.0, 176.0, 184, 192.0, 200.0, 208.0, 216.0, 224.0, 232.0, 240.0, 248.0, 256.0, 264.0, 272.0, 280.0, 288.0, 296.0, 304.0, 312.0, 320.0, 328.0, 336.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }

    /**
     * @return float[]
     */
    public function getTommorwSpotPricesEarlyDst(): array
    {
        // 23 hours = 92 quarters (DST spring forward loses 1 hour)
        $hourlyPrices = [352.0, 360.0, 368.0, 376.0, 384.0, 392.0, 400.0, 408.0, 416.0, 424.0, 432.0, 440.0, 448.0, 456.0, 464.0, 472.0, 480.0, 488.0, 496.0, 504.0, 512.0, 520.0, 528.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }

    private function getTodaySpotPricesLateDst() : array
    {
        // 25 hours = 100 quarters (DST fall back gains 1 hour)
        $hourlyPrices = [352.0, 360.0, 368.0, 376.0, 384.0, 392.0, 400.0, 408.0, 416.0, 424.0, 432.0, 440.0, 448.0, 456.0, 464.0, 472.0, 480.0, 488.0, 496.0, 504.0, 512.0, 520.0, 528.0, 536.0, 544.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }

    private function getTommorwSpotPricesLateDst() : array
    {
        // 25 hours = 100 quarters (DST fall back gains 1 hour)
        $hourlyPrices = [352.0, 360.0, 368.0, 376.0, 384.0, 392.0, 400.0, 408.0, 416.0, 424.0, 432.0, 440.0, 448.0, 456.0, 464.0, 472.0, 480.0, 488.0, 496.0, 504.0, 512.0, 520.0, 528.0, 536.0, 544.0];
        $quarterPrices = [];
        foreach ($hourlyPrices as $price) {
            for ($i = 0; $i < 4; $i++) {
                $quarterPrices[] = $price;
            }
        }

        return $quarterPrices;
    }
}
