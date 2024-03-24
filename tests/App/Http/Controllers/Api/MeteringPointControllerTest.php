<?php

namespace Tests\App\Http\Controllers\Api;

use App\Http\Controllers\Api\MeteringPointController;
use App\Http\Requests\StoreMeteringPointRequest;
use App\Http\Requests\UpdateMeteringPointRequest;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\GetMeteringData;
use Mockery;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class MeteringPointControllerTest extends TestCase
{
    private MeteringPointController $meteringPointController;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $meteringDataService = $this->createMock(GetMeteringData::class);
        $this->meteringPointController = new MeteringPointController($meteringDataService);
    }

    public function testIndex() : void
    {
        $response = $this->meteringPointController->index();
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
    }

    public function testStore() : void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $storeMeteringPointRequest = Mockery::mock(StoreMeteringPointRequest::class)->makePartial();
        $meteringPoint = MeteringPoint::factory()->create(['metering_point_id' => 'dsfdsfds', 'type_of_mp' => '1', 'settlement_method' => 'D02', 'meter_number' => '1234', 'meter_reading_occurrence' => 'PYTH1', 'balance_supplier_name' => 'supplier', 'street_code' => '123', 'street_name' => 'Omvejen', 'building_number' => '12', 'city_name' => 'Ørsted', 'municipality_code' => '123', 'hasRelation' => 0]);
        $storeMeteringPointRequest->shouldReceive('all')
            ->andReturn($meteringPoint->toArray());
        $storeMeteringPointRequest->shouldReceive('validated')
            ->andReturn($meteringPoint->toArray());
        $response = $this->meteringPointController->store($storeMeteringPointRequest);
        $this->assertIsArray($response);
    }

    /**
     * @throws Exception
     */
    public function testShow() : void
    {
        $meteringPoint = $this->createMock(MeteringPoint::class);
        $response = $this->meteringPointController->show($meteringPoint);
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdate() : void
    {
        $meteringPoint = MeteringPoint::factory()->create(['metering_point_id' => 'dsfdsfds', 'type_of_mp' => '1', 'settlement_method' => 'D02', 'meter_number' => '1234', 'meter_reading_occurrence' => 'PYTH1', 'balance_supplier_name' => 'supplier', 'street_code' => '123', 'street_name' => 'Omvejen', 'building_number' => '12', 'city_name' => 'Ørsted', 'municipality_code' => '123', 'hasRelation' => 0]);

        $updateMeteringPointRequest = Mockery::mock(UpdateMeteringPointRequest::class)->makePartial();

        $updateMeteringPointRequest->shouldReceive('all')
            ->andReturn($meteringPoint->toArray());
        $updateMeteringPointRequest->shouldReceive('validated')
            ->andReturn($meteringPoint->toArray());
        $parameterBag = Mockery::mock(ParameterBag::class)->makePartial();
        $parameterBag->shouldReceive('get')
            ->andReturn(true);
        $updateMeteringPointRequest->attributes = $parameterBag;
        $headerBag = Mockery::mock(HeaderBag::class)->makePartial();
        $updateMeteringPointRequest->headers = $headerBag;

        $response = $this->meteringPointController->update($updateMeteringPointRequest, $meteringPoint);
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testDestroy() : void
    {
        $meteringPoint = $this->createMock(MeteringPoint::class);
        $response = $this->meteringPointController->destroy($meteringPoint);
        $this->assertEquals(ResponseAlias::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
