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

    public function test_invoke_at_midnight()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 24;
        });
    }

    public function test_invoke_before_1pm()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 13;
        });
    }

    public function test_invoke_after_1pm()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 34 && $value['2023-01-01 14:00:00+01:00'] == 39.09 && $value['2023-01-02 00:00:00+01:00'] == 39.19;
        });
    }

    /**
     * Happy-paths END.
     */

    /**
     * Cases with empty spot-prices BEGIN.
     */
    public function test_invoke_before_1pm_but_spot_prices_cant_be_provided()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('error', function ($value) {
            return $value == 'It wasn\'t possible to get today\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
        });
    }

    public function test_invoke_after_1pm_but_tomorrows_spot_prices_cant_be_provided()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('warning', function ($value) {
            return $value == 'It wasn\'t possible to get tomorrow\'s day-ahead prices from "ENERGI DATA SERVICE" ( https://api.energidataservice.dk )';
        });

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 10 && $value['2023-01-01 14:00:00+01:00'] == 39.09;
        });
    }

    /**
     * Cases with empty spot-prices END.
     */

    /**
     * Edge cases BEGIN.
     */
    public function test_invoke_before_1pm_dst_early_is_today()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 22;
        });
    }

    public function test_invoke_after_1pm_dst_early_is_today()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 33 && $value['2023-03-26 16:00:00+02:00'] == 39.1 && $value['2023-03-27 00:00:00+02:00'] == 39.19;
        });
    }

    public function test_invoke_after_1pm_dst_early_is_tomorrow()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 33 && $value['2023-03-25 15:00:00+01:00'] == 39.1 && $value['2023-03-26 00:00:00+01:00'] == 39.19;
        });
    }

    public function test_invoke_before_1pm_dst_late_is_today()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 24;
        });
    }

    public function test_invoke_after_1pm_dst_late_is_today()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 35 && $value['2023-10-29 15:00:00+01:00'] == 39.35 && $value['2023-10-30 00:00:00+01:00'] == 39.19;
        });
    }

    public function test_invoke_after_1pm_dst_late_is_tomorrow()
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
            $this->assertSessionHas($key, $value);
        }

        $response->assertSessionHas('data', function ($value) {
            return count($value) === 35 && $value['2023-10-28 15:00:00+02:00'] == 39.1 && $value['2023-10-29 00:00:00+02:00'] == 39.19;
        });
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
        return [
            0 => 160,
            1 => 168.0,
            2 => 176.0,
            3 => 184,
            4 => 192.0,
            5 => 200.0,
            6 => 208.0,
            7 => 216.0,
            8 => 224.0,
            9 => 232.0,
            10 => 240.0,
            11 => 248.0,
            12 => 256.0,
            13 => 264.0,
            14 => 272.0,
            15 => 280.0,
            16 => 288.0,
            17 => 296.0,
            18 => 304.0,
            19 => 312.0,
            20 => 320.0,
            21 => 328.0,
            22 => 336.0,
            23 => 344.0,
        ];
    }

    /**
     * @return float[]
     */
    public function getTommorwSpotPrices(): array
    {
        return [
            0 => 352.0,
            1 => 360.0,
            2 => 368.0,
            3 => 376.0,
            4 => 384.0,
            5 => 392.0,
            6 => 400.0,
            7 => 408.0,
            8 => 416.0,
            9 => 424.0,
            10 => 432.0,
            11 => 440.0,
            12 => 448.0,
            13 => 456.0,
            14 => 464.0,
            15 => 472.0,
            16 => 480.0,
            17 => 488.0,
            18 => 496.0,
            19 => 504.0,
            20 => 512.0,
            21 => 520.0,
            22 => 528.0,
            23 => 536.0,
        ];
    }

    /**
     * @return array
     */
    public function getTodaySpotPricesEarlyDst(): array
    {
        return [
            0 => 160,
            1 => 168.0,
            2 => 176.0,
            3 => 184,
            4 => 192.0,
            5 => 200.0,
            6 => 208.0,
            7 => 216.0,
            8 => 224.0,
            9 => 232.0,
            10 => 240.0,
            11 => 248.0,
            12 => 256.0,
            13 => 264.0,
            14 => 272.0,
            15 => 280.0,
            16 => 288.0,
            17 => 296.0,
            18 => 304.0,
            19 => 312.0,
            20 => 320.0,
            21 => 328.0,
            22 => 336.0,
        ];
    }

    /**
     * @return float[]
     */
    public function getTommorwSpotPricesEarlyDst(): array
    {
        return [
            0 => 352.0,
            1 => 360.0,
            2 => 368.0,
            3 => 376.0,
            4 => 384.0,
            5 => 392.0,
            6 => 400.0,
            7 => 408.0,
            8 => 416.0,
            9 => 424.0,
            10 => 432.0,
            11 => 440.0,
            12 => 448.0,
            13 => 456.0,
            14 => 464.0,
            15 => 472.0,
            16 => 480.0,
            17 => 488.0,
            18 => 496.0,
            19 => 504.0,
            20 => 512.0,
            21 => 520.0,
            22 => 528.0,
        ];
    }

    private function getTodaySpotPricesLateDst()
    {
        return [
            0 => 352.0,
            1 => 360.0,
            2 => 368.0,
            3 => 376.0,
            4 => 384.0,
            5 => 392.0,
            6 => 400.0,
            7 => 408.0,
            8 => 416.0,
            9 => 424.0,
            10 => 432.0,
            11 => 440.0,
            12 => 448.0,
            13 => 456.0,
            14 => 464.0,
            15 => 472.0,
            16 => 480.0,
            17 => 488.0,
            18 => 496.0,
            19 => 504.0,
            20 => 512.0,
            21 => 520.0,
            22 => 528.0,
            23 => 536.0,
            24 => 544.0,
        ];
    }

    private function getTommorwSpotPricesLateDst()
    {
        return [
            0 => 352.0,
            1 => 360.0,
            2 => 368.0,
            3 => 376.0,
            4 => 384.0,
            5 => 392.0,
            6 => 400.0,
            7 => 408.0,
            8 => 416.0,
            9 => 424.0,
            10 => 432.0,
            11 => 440.0,
            12 => 448.0,
            13 => 456.0,
            14 => 464.0,
            15 => 472.0,
            16 => 480.0,
            17 => 488.0,
            18 => 496.0,
            19 => 504.0,
            20 => 512.0,
            21 => 520.0,
            22 => 528.0,
            23 => 536.0,
            24 => 544.0,
        ];
    }
}
