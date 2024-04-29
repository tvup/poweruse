<?php

namespace Tests\Services;

use App\Enums\SourceEnum;
use App\Models\MeteringPoint;
use App\Models\User;
use App\Services\GetMeteringData;
use Illuminate\Support\Carbon;
use Mockery\MockInterface;
use Tests\TestCase;
use Tvup\ElOverblikApi\ElOverblikApiInterface;

class GetMeteringDataTest extends TestCase
{
    public function testGetMeteringPointDataDatahub(): void
    {
        $meteringPointArray = [
            'streetCode' => '3546',
            'streetName' => 'Jernbane Alle',
            'buildingNumber' => '37',
            'floorId' => null,
            'roomId' => null,
            'citySubDivisionName' => null,
            'municipalityCode' => '169',
            'locationDescription' => 'i kælder',
            'settlementMethod' => 'D01',
            'meterReadingOccurrence' => 'PT1H',
            'firstConsumerPartyName' => 'Torben Evald Hansen',
            'secondConsumerPartyName' => null,
            'meterNumber' => '21517435',
            'consumerStartDate' => '2013-06-30T22:00:00.000Z',
            'meteringPointId' => '571313174112923291',
            'typeOfMP' => 'E17',
            'balanceSupplierName' => 'EWII Energi A/S',
            'postcode' => '2630',
            'cityName' => 'Taastrup',
            'hasRelation' => true,
            'consumerCVR' => null,
            'dataAccessCVR' => null,
            'childMeteringPoints' => [],
            'source' => SourceEnum::DATAHUB,
        ];

        $mopclk = $this->mock(ElOverblikApiInterface::class, function (MockInterface $mock) use ($meteringPointArray) {
            $mock
                ->shouldReceive('token')
                ->once()
                ->andReturnNull();
            $mock
                ->shouldReceive('getMeteringPointData')
                ->once()
                ->andReturn($meteringPointArray);
        });

        $meteringPoint = app(GetMeteringData::class)->getMeteringPointData(SourceEnum::DATAHUB, ['refresh_token'=>'token']);

        $this->assertNotNull($meteringPoint);
        $this->assertEquals($meteringPointArray['streetCode'], $meteringPoint->street_code);
        $this->assertEquals($meteringPointArray['streetName'], $meteringPoint->street_name);
        $this->assertEquals($meteringPointArray['buildingNumber'], $meteringPoint->building_number);
        $this->assertEquals($meteringPointArray['floorId'], $meteringPoint->floor_id);
        $this->assertEquals($meteringPointArray['roomId'], $meteringPoint->room_id);
        $this->assertEquals($meteringPointArray['citySubDivisionName'], $meteringPoint->city_sub_division_name);
        $this->assertEquals($meteringPointArray['municipalityCode'], $meteringPoint->municipality_code);
        $this->assertEquals($meteringPointArray['locationDescription'], $meteringPoint->location_description);
        $this->assertEquals($meteringPointArray['settlementMethod'], $meteringPoint->settlement_method);
        $this->assertEquals($meteringPointArray['meterReadingOccurrence'], $meteringPoint->meter_reading_occurrence);
        $this->assertEquals($meteringPointArray['firstConsumerPartyName'], $meteringPoint->first_consumer_party_name);
        $this->assertEquals($meteringPointArray['secondConsumerPartyName'], $meteringPoint->second_consumer_party_name);
        $this->assertEquals($meteringPointArray['meterNumber'], $meteringPoint->meter_number);
        $this->assertEquals(Carbon::parse($meteringPointArray['consumerStartDate'], 'UTC')->timezone('Europe/Copenhagen'), $meteringPoint->consumer_start_date);
        $this->assertEquals($meteringPointArray['meteringPointId'], $meteringPoint->metering_point_id);
        $this->assertEquals($meteringPointArray['typeOfMP'], $meteringPoint->type_of_mp);
        $this->assertEquals($meteringPointArray['balanceSupplierName'], $meteringPoint->balance_supplier_name);
        $this->assertEquals($meteringPointArray['cityName'], $meteringPoint->city_name);
        $this->assertEquals($meteringPointArray['hasRelation'], $meteringPoint->hasRelation);
        $this->assertEquals($meteringPointArray['consumerCVR'], $meteringPoint->consumer_c_v_r);
        $this->assertEquals($meteringPointArray['dataAccessCVR'], $meteringPoint->data_access_c_v_r);
        $this->assertEquals($meteringPointArray['source'], $meteringPoint->source);
    }

    public function testGetMeteringPointDataPoweruse() : void
    {
        $baseMeteringPoint = MeteringPoint::factory()->create();
        $user = User::factory()->create();
        $baseMeteringPoint->user()->associate($user);
        $baseMeteringPoint->save();

        $retrievedMeteringPoint = app(GetMeteringData::class)->getMeteringPointData(SourceEnum::POWERUSE, [], $user);

        $this->assertNotNull($retrievedMeteringPoint);

        $this->assertEquals($baseMeteringPoint->street_code, $retrievedMeteringPoint->street_code);
        $this->assertEquals($baseMeteringPoint->street_name, $retrievedMeteringPoint->street_name);
        $this->assertEquals($baseMeteringPoint->building_number, $retrievedMeteringPoint->building_number);
        $this->assertEquals($baseMeteringPoint->floor_id, $retrievedMeteringPoint->floor_id);
        $this->assertEquals($baseMeteringPoint->room_id, $retrievedMeteringPoint->room_id);
        $this->assertEquals($baseMeteringPoint->city_sub_division_name, $retrievedMeteringPoint->city_sub_division_name);
        $this->assertEquals($baseMeteringPoint->municipality_code, $retrievedMeteringPoint->municipality_code);
        $this->assertEquals($baseMeteringPoint->location_description, $retrievedMeteringPoint->location_description);
        $this->assertEquals($baseMeteringPoint->settlement_method, $retrievedMeteringPoint->settlement_method);
        $this->assertEquals($baseMeteringPoint->meter_reading_occurrence, $retrievedMeteringPoint->meter_reading_occurrence);
        $this->assertEquals($baseMeteringPoint->first_consumer_party_name, $retrievedMeteringPoint->first_consumer_party_name);
        $this->assertEquals($baseMeteringPoint->second_consumer_party_name, $retrievedMeteringPoint->second_consumer_party_name);
        $this->assertEquals($baseMeteringPoint->meter_number, $retrievedMeteringPoint->meter_number);
        $this->assertEquals($baseMeteringPoint->consumer_start_date, $retrievedMeteringPoint->consumer_start_date);
        $this->assertEquals($baseMeteringPoint->metering_point_id, $retrievedMeteringPoint->metering_point_id);
        $this->assertEquals($baseMeteringPoint->type_of_mp, $retrievedMeteringPoint->type_of_mp);
        $this->assertEquals($baseMeteringPoint->balance_supplier_name, $retrievedMeteringPoint->balance_supplier_name);
        $this->assertEquals($baseMeteringPoint->city_name, $retrievedMeteringPoint->city_name);
        $this->assertEquals($baseMeteringPoint->hasRelation, $retrievedMeteringPoint->hasRelation);
        $this->assertEquals($baseMeteringPoint->consumer_c_v_r, $retrievedMeteringPoint->consumer_c_v_r);
        $this->assertEquals($baseMeteringPoint->data_access_c_v_r, $retrievedMeteringPoint->data_access_c_v_r);
    }
}
