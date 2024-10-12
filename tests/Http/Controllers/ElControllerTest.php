<?php

namespace Tests\Http\Controllers;

use App\Exceptions\DataUnavailableException;
use App\Models\Charge;
use App\Models\DatahubPriceList;
use App\Models\MeteringPoint;
use App\Models\Operator;
use App\Models\User;
use App\Services\GetDatahubPriceLists;
use App\Services\GetMeteringData;
use App\Services\GetSmartMeMeterData;
use App\Services\GetSpotPrices;
use App\Services\Interfaces\GetSpotPricesInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;
use Tvup\ElOverblikApi\ElOverblikApiException;

class ElControllerTest extends TestCase
{
    use WithoutMiddleware; // Brug denne trait, hvis du vil ignorere middleware under testen.

    private array $consumption;

    private array $smartMeData;

    public function setUp() : void
    {
        parent::setup();
        $this->consumption = $this->loadTestData(test_fixture_path('consumption_data2.json'));
        $this->smartMeData = $this->loadTestData(test_fixture_path('consumption_data3.json'));
    }

    public function test_it_returns_total_price_for_today() : void
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

        $this->mock(GetSpotPrices::class)->shouldReceive('getData')->andReturn($this->consumption);

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
    }

    public function test_index() :void
    {
        $response = $this->get('/el');
        $response->assertStatus(200);
        $response->assertSee('Beregning af energi-data');
    }

    public function test_index_spotprices() :void
    {
        $response = $this->get('/el-spotprices');
        $response->assertStatus(200);
        $response->assertSee('Hent spotpriser');
    }

    public function test_index_consumption() :void
    {
        $response = $this->get('/consumption');
        $response->assertStatus(200);
        $response->assertSee('Hent forbrug');
    }

    public function test_index_custom_usage() :void
    {
        $response = $this->get('/el-custom');
        $response->assertStatus(200);
        $response->assertSee('Beregning af et bestemt forbrug i dag');
    }

    public function test_process_data() :void
    {
        $user = User::factory()->create();
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
            'token' => 's',
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);
        $charge1 = new Charge(['type'=>'Abonnement', 'name'=>'TSO - System Abonnement', 'price'=>15, 'owner' => '5790000432752', 'description'=>'Abonnement TSO']);
        $charge2 = new Charge(['type'=>'Abonnement', 'name'=>'Netabo C forbrug', 'price'=>44.75, 'owner' => '5790000705689', 'description'=>'Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en timeaflæst måler']);
        $charge3 = new Charge(['type'=>'Tarif', 'name'=>'Transmissions nettarif', 'owner' => '5790000432752', 'description'=>'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.']);
        $charge4 = new Charge(['type'=>'Tarif', 'name'=>'Systemtarif', 'owner' => '5790000432752', 'description'=>'Systemafgiften dækker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.']);
        $charge5 = new Charge(['type'=>'Tarif', 'name'=>'Elafgift', 'owner' => '5790000432752', 'description'=>'Elafgiften']);
        $charge6 = new Charge(['type'=>'Tarif', 'name'=>'Nettarif C', 'owner' => '5790000705689', 'description'=>'Nettarif C']);
        $mock->shouldReceive('getCharges')->andReturn([collect([$charge1, $charge2]), collect([$charge3, $charge4, $charge5, $charge6]), collect([])]);
        $datahubPriceList = new DatahubPriceList(['Note'=>'Transmissions nettarif', 'Price1'=>0.06, 'ValidFrom'=>'2023-01-01', 'ValidTo'=>null]);
        $newMoce = $this->mock(GetDatahubPriceLists::class)->shouldReceive('getFromQuery')->andReturn(collect([$datahubPriceList]));
        $newMoce->shouldReceive('getQueryForFetchingSpecificTariffFromDB')->andReturn(DatahubPriceList::whereNote(''));

        $newMoee = $this->mock(GetSpotPricesInterface::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_process_data_no_token() :void
    {
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $response = $this->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Failed - token cannot be empty.');
    }

    public function test_process_data_token_on_user() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);
        $charge1 = new Charge(['type'=>'Abonnement', 'name'=>'TSO - System Abonnement', 'price'=>15, 'owner' => '5790000432752', 'description'=>'Abonnement TSO']);
        $charge2 = new Charge(['type'=>'Abonnement', 'name'=>'Netabo C forbrug', 'price'=>44.75, 'owner' => '5790000705689', 'description'=>'Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en timeaflæst måler']);
        $charge3 = new Charge(['type'=>'Tarif', 'name'=>'Transmissions nettarif', 'owner' => '5790000432752', 'description'=>'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.']);
        $charge4 = new Charge(['type'=>'Tarif', 'name'=>'Systemtarif', 'owner' => '5790000432752', 'description'=>'Systemafgiften dækker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.']);
        $charge5 = new Charge(['type'=>'Tarif', 'name'=>'Elafgift', 'owner' => '5790000432752', 'description'=>'Elafgiften']);
        $charge6 = new Charge(['type'=>'Tarif', 'name'=>'Nettarif C', 'owner' => '5790000705689', 'description'=>'Nettarif C']);
        $mock->shouldReceive('getCharges')->andReturn([collect([$charge1, $charge2]), collect([$charge3, $charge4, $charge5, $charge6]), collect([])]);
        $datahubPriceList = new DatahubPriceList(['Note'=>'Transmissions nettarif', 'Price1'=>0.06, 'ValidFrom'=>'2023-01-01', 'ValidTo'=>null]);
        $newMoce = $this->mock(GetDatahubPriceLists::class)->shouldReceive('getFromQuery')->andReturn(collect([$datahubPriceList]));
        $newMoce->shouldReceive('getQueryForFetchingSpecificTariffFromDB')->andReturn(DatahubPriceList::whereNote(''));

        $newMoee = $this->mock(GetSpotPricesInterface::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_process_data_with_smart_me() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
            'smart_me' => true,
            'smartmeuser' => 'true',
            'smartmepassword' => 'true',
            'smartmeid' => 'true',
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);
        $charge1 = new Charge(['type'=>'Abonnement', 'name'=>'TSO - System Abonnement', 'price'=>15, 'owner' => '5790000432752', 'description'=>'Abonnement TSO']);
        $charge2 = new Charge(['type'=>'Abonnement', 'name'=>'Netabo C forbrug', 'price'=>44.75, 'owner' => '5790000705689', 'description'=>'Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en timeaflæst måler']);
        $charge3 = new Charge(['type'=>'Tarif', 'name'=>'Transmissions nettarif', 'owner' => '5790000432752', 'description'=>'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.']);
        $charge4 = new Charge(['type'=>'Tarif', 'name'=>'Systemtarif', 'owner' => '5790000432752', 'description'=>'Systemafgiften dækker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.']);
        $charge5 = new Charge(['type'=>'Tarif', 'name'=>'Elafgift', 'owner' => '5790000432752', 'description'=>'Elafgiften']);
        $charge6 = new Charge(['type'=>'Tarif', 'name'=>'Nettarif C', 'owner' => '5790000705689', 'description'=>'Nettarif C']);
        $mock->shouldReceive('getCharges')->andReturn([collect([$charge1, $charge2]), collect([$charge3, $charge4, $charge5, $charge6]), collect([])]);
        $datahubPriceList = new DatahubPriceList(['Note'=>'Transmissions nettarif', 'Price1'=>0.06, 'ValidFrom'=>'2023-01-01', 'ValidTo'=>null]);
        $newMoce = $this->mock(GetDatahubPriceLists::class)->shouldReceive('getFromQuery')->andReturn(collect([$datahubPriceList]));
        $newMoce->shouldReceive('getQueryForFetchingSpecificTariffFromDB')->andReturn(DatahubPriceList::whereNote(''));

        $newSmartMoce = $this->mock(GetSmartMeMeterData::class)->shouldReceive('getInterval')->andReturn($this->smartMeData);

        $newMoee = $this->mock(GetSpotPricesInterface::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_process_data_throws_exception() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new ElOverblikApiException('hej', ''));

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(500);
        $response->assertSee('hej');
    }

    public function test_process_data_throws_exception_400() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new ElOverblikApiException(['Verb'=>'', 'Endpoint'=>'', 'Code'=>'', 'Response'=>''], '', 400));

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    public function test_process_data_throws_exception_401() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new ElOverblikApiException(['Verb'=>'', 'Endpoint'=>'', 'Code'=>'', 'Response'=>''], '', 401));

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    public function test_process_data_throws_exception_DataUnavailableException() :void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $start_date = '2024-03-01';
        $end_date = '2024-04-01';
        $area = 'DK2';
        $subscription = 20;
        $overhead = 0.01;
        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'area' => $area,
            'subscription' => $subscription,
            'overhead' => $overhead,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new DataUnavailableException('hej', 401));

        $response = $this->actingAs($user)->post('/processdata', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'hej');
    }

    public function test_get_consumption() : void
    {
        $user = User::factory()->create();
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'DATAHUB';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'token'=>'s',
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_get_consumption_with_token_on_user() : void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'DATAHUB';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_get_consumption_throws_exception() : void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'DATAHUB';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new ElOverblikApiException(['Verb'=>'', 'Endpoint'=>'', 'Code'=>'', 'Response'=>''], '', 401));

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Failed - cannot login with credentials.');
    }

    public function test_get_consumption_throws_random_exception() : void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'DATAHUB';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andThrow(new ElOverblikApiException(['Davdu'], '', 409));

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(409);
        $response->assertSee('Davdu');
    }

    public function test_get_consumption_smart_me() : void
    {
        $user = User::factory()->create(['refresh_token'=>'s']);
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'SMART_ME';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'smart_me' => 'on',
            'smartmeuser' => 'true',
            'smartmepassword' => 'true',
            'smartmeid' => 'true',
        ];

        $mock = $this->mock(GetSmartMeMeterData::class)->shouldReceive('getInterval')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertSessionHas('status', 'Alt data hentet');
    }

    public function test_get_consumption_no_token() : void
    {
        $user = User::factory()->create();
        MeteringPoint::factory()->create(['user_id'=>$user->id, 'metering_point_id' => '571313174112923291']);
        $source = 'DATAHUB';
        $startDate = '2024-03-01';
        $endDate = '2024-04-01';
        $data = [
            'source' => $source,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $mock = $this->mock(GetMeteringData::class)->shouldReceive('getData')->andReturn($this->consumption);

        $response = $this->actingAs($user)->post('/getConsumption', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Request token should be provided either on input or saved on user');
    }
}
