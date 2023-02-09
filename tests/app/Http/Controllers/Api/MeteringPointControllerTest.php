<?php

use App\Http\Controllers\Api\MeteringPointController;
use App\Http\Requests\StoreMeteringPointRequest;
use App\Http\Requests\UpdateMeteringPointRequest;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\GetMeteringData;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\HeaderBag;
use Tests\TestCase;

class MeteringPointControllerTest extends TestCase
{
    private GetMeteringData $meteringDataService;

    private MeteringPointController $meteringPointController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->meteringDataService = $this->createMock(GetMeteringData::class);
        $this->meteringPointController = new MeteringPointController($this->meteringDataService);
    }

    public function testIndex()
    {
        $response = $this->meteringPointController->index();
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $storeMeteringPointRequest = \Mockery::mock(StoreMeteringPointRequest::class)->makePartial();
        $array = ['metering_point_id' => 'dsfdsfds', 'type_of_mp' => '1', 'settlement_method' => 'D02', 'meter_number' => '1234', 'meter_reading_occurrence' => 'PYTH1', 'balance_supplier_name' => 'supplier', 'street_code' => '123', 'street_name' => 'Omvejen', 'building_number' => '12', 'city_name' => 'Ørsted', 'municipality_code' => '123', 'hasRelation' => 0];
        $storeMeteringPointRequest->shouldReceive('all')
            ->andReturn($array);
        $storeMeteringPointRequest->shouldReceive('validated')
            ->andReturn($array);
        $response = $this->meteringPointController->store($storeMeteringPointRequest);
        $this->assertIsArray($response);
    }

    public function testShow()
    {
        $meteringPoint = $this->createMock(MeteringPoint::class);
        $response = $this->meteringPointController->show($meteringPoint);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testUpdate()
    {
        $updateMeteringPointRequest = \Mockery::mock(UpdateMeteringPointRequest::class)->makePartial();
        $array = ['metering_point_id' => 'dsfdsfds', 'type_of_mp' => '1', 'settlement_method' => 'D02', 'meter_number' => '1234', 'meter_reading_occurrence' => 'PYTH1', 'balance_supplier_name' => 'supplier', 'street_code' => '123', 'street_name' => 'Omvejen', 'building_number' => '12', 'city_name' => 'Ørsted', 'municipality_code' => '123', 'hasRelation' => 0];
        $updateMeteringPointRequest->shouldReceive('all')
            ->andReturn($array);
        $updateMeteringPointRequest->shouldReceive('validated')
            ->andReturn($array);
        $parameterBag = \Mockery::mock(\Symfony\Component\HttpFoundation\ParameterBag::class)->makePartial();
        $parameterBag->shouldReceive('get')
            ->andReturn(true);
        $updateMeteringPointRequest->attributes = $parameterBag;
        $headerBag = \Mockery::mock(HeaderBag::class)->makePartial();
        $updateMeteringPointRequest->headers = $headerBag;

        $meteringPoint = new MeteringPoint(['metering_point_id' => 'dsfdsfds', 'type_of_mp' => '1', 'settlement_method' => 'D02', 'meter_number' => '1234', 'meter_reading_occurrence' => 'PYTH1', 'balance_supplier_name' => 'supplier', 'street_code' => '123', 'street_name' => 'Omvejen', 'building_number' => '12', 'city_name' => 'Ørsted', 'municipality_code' => '123', 'hasRelation' => 0]);
        $response = $this->meteringPointController->update($updateMeteringPointRequest, $meteringPoint);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $meteringPoint = $this->createMock(MeteringPoint::class);
        $response = $this->meteringPointController->destroy($meteringPoint);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NO_CONTENT);
    }
}
