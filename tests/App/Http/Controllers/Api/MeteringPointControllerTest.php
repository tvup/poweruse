<?php

namespace Tests\App\Http\Controllers\Api;

use App\Http\Controllers\Api\MeteringPointController;
use App\Http\Requests\StoreMeteringPointRequest;
use App\Http\Requests\UpdateMeteringPointRequest;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\GetMeteringData;
use Mockery;
use Mockery\MockInterface;
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

    public function testGetMeteringPointDataDatahub() : void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $meteringPoint = MeteringPoint::factory()->create([
            'metering_point_id' => '571313174112923291',
            'type_of_mp' => 'E17',
            'settlement_method' => 'D01',
            'meter_number' => '21517435',
            'consumer_c_v_r' => null,
            'data_access_c_v_r' => null,
            'consumer_start_date' => '2013-06-30T22:00:00.000Z',
            'meter_reading_occurrence' => 'PT1H',
            'balance_supplier_name' => 'EWII Energi A/S',
            'street_code' => '3546',
            'street_name' => 'Jernbane Alle',
            'building_number' => '37',
            'floor_id' => null,
            'room_id' => null,
            'city_name' => 'Taastrup',
            'city_sub_division_name' => null,
            'municipality_code' => '169',
            'location_description' => 'i kælder',
            'first_consumer_party_name' => 'Torben Evald Hansen',
            'second_consumer_party_name' => null,
            'hasRelation' => true,
        ]);
        $mopclk = $this->mock(GetMeteringData::class, function (MockInterface $mock) use ($meteringPoint) {
            $mock
                ->shouldReceive('getMeteringPointData')
                ->once()
                ->andReturn($meteringPoint);
        });

        $controller = new MeteringPointController($mopclk);

        $response = $controller->index();

        $this->assertJson($meteringPoint, $response);
        $this->assertEquals(ResponseAlias::HTTP_OK, $response->getStatusCode());
    }

    public function testGetMeteringPointDataPoweruse() : void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $meteringPoint = MeteringPoint::factory()->create(
            [
            'metering_point_id' => 'et',
            'parent_id' => 'distinctio',
            'type_of_mp' => 'quasi',
            'settlement_method' => 'nobis',
            'meter_number' => 'consequatur',
            'consumer_c_v_r' => '1058957',
            'data_access_c_v_r' => '2052101',
            'consumer_start_date' => '2024-03-25 00:39:23',
            'meter_reading_occurrence' => 'optio',
            'balance_supplier_name' => 'Laron Mraz',
            'street_code' => 'Brad Radial',
            'street_name' => 'Broderick Mosciski PhD',
            'building_number' => 'optio',
            'floor_id' => 'k',
            'room_id' => 'u',
            'city_name' => 'Dr. Mariana Hauck',
            'city_sub_division_name' => 'Dr. Lafayette Thompson',
            'municipality_code' => 'amet',
            'location_description' => 'iusto natus provident ut',
            'first_consumer_party_name' => 'Freddie',
            'second_consumer_party_name' => 'Dexter Quigley',
            'hasRelation' => 0,
            'created_at' => '2024-03-25 00:39:23',
            'updated_at' => '2024-03-25 00:39:23']
        );
        $meteringPoint->user()->associate($user);
        $meteringPoint->save();

        $mopclk = $this->mock(GetMeteringData::class, function (MockInterface $mock) use ($meteringPoint) {
            $mock
                ->shouldReceive('getMeteringPointData')
                ->once()
                ->andReturn($meteringPoint);
        });

        $controller = new MeteringPointController($mopclk);

        $response = $controller->index();

        $this->assertJson($meteringPoint, $response);
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
