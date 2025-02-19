<?php

namespace App\Services\Transformers;

use App\Enums\SourceEnum;
use App\Models\MeteringPoint;

class MeteringPointTransformerBase
{
    public function transform(array $data, SourceEnum $source): MeteringPoint
    {
        switch ($source) {
            case SourceEnum::DATAHUB:
                return $this->transformDatahubData($data);
            case SourceEnum::POWERUSE:
                return $this->transformPowerUseData($data);
            default:
                throw new \InvalidArgumentException($source->value . ' is not a valid source for this transformation');
        }
    }

    public function prepareForJson(MeteringPoint $data): array
    {
        $meteringPoint = [];
        $meteringPoint['id'] = $data->id;
        $meteringPoint['metering_point_id'] = $data->metering_point_id;
        $meteringPoint['type_of_mp'] = $data->type_of_mp;
        $meteringPoint['settlement_method'] = $data->settlement_method;
        $meteringPoint['meter_number'] = $data->meter_number;
        $meteringPoint['consumer_c_v_r'] = $data->consumer_c_v_r;
        $meteringPoint['data_access_c_v_r'] = $data->data_access_c_v_r;
        $meteringPoint['consumer_start_date'] = $data->consumer_start_date;
        $meteringPoint['meter_reading_occurrence'] = $data->meter_reading_occurrence;
        $meteringPoint['balance_supplier_name'] = $data->balance_supplier_name;
        $meteringPoint['street_code'] = $data->street_code;
        $meteringPoint['street_name'] = $data->street_name;
        $meteringPoint['building_number'] = $data->building_number;
        $meteringPoint['floor_id'] = $data->floor_id;
        $meteringPoint['room_id'] = $data->room_id;
        $meteringPoint['city_name'] = $data->city_name;
        $meteringPoint['city_sub_division_name'] = $data->city_sub_division_name;
        $meteringPoint['municipality_code'] = $data->municipality_code;
        $meteringPoint['location_description'] = $data->location_description;
        $meteringPoint['first_consumer_party_name'] = $data->first_consumer_party_name;
        $meteringPoint['second_consumer_party_name ='] = $data->second_consumer_party_name;
        $meteringPoint['hasRelation'] = $data->hasRelation;
        $meteringPoint['source'] = $data->source ? $data->source->value : 'POWERUSE';

        return $meteringPoint;
    }

    private function transformDatahubData(array $data): MeteringPoint
    {
        $meteringPoint = app()->make(MeteringPoint::class);
        $meteringPoint->metering_point_id = $data['meteringPointId'];
        $meteringPoint->type_of_mp = $data['typeOfMP'];
        $meteringPoint->settlement_method = $data['settlementMethod'];
        $meteringPoint->meter_number = $data['meterNumber'];
        $meteringPoint->consumer_c_v_r = $data['consumerCVR'];
        $meteringPoint->data_access_c_v_r = $data['dataAccessCVR'];
        $meteringPoint->consumer_start_date = $data['consumerStartDate'];
        $meteringPoint->meter_reading_occurrence = $data['meterReadingOccurrence'];
        $meteringPoint->balance_supplier_name = $data['balanceSupplierName'];
        $meteringPoint->street_code = $data['streetCode'];
        $meteringPoint->street_name = $data['streetName'];
        $meteringPoint->building_number = $data['buildingNumber'];
        $meteringPoint->floor_id = $data['floorId'];
        $meteringPoint->room_id = $data['roomId'];
        $meteringPoint->city_name = $data['cityName'];
        $meteringPoint->city_sub_division_name = $data['citySubDivisionName'];
        $meteringPoint->municipality_code = $data['municipalityCode'];
        $meteringPoint->location_description = $data['locationDescription'];
        $meteringPoint->first_consumer_party_name = $data['firstConsumerPartyName'];
        $meteringPoint->second_consumer_party_name = $data['secondConsumerPartyName'];
        $meteringPoint->hasRelation = $data['hasRelation'];
        $meteringPoint->source = $data['source'];

        return $meteringPoint;
    }

    private function transformPowerUseData(array $data): MeteringPoint
    {
        $meteringPoint = new MeteringPoint();
        $meteringPoint->id = $data['id'];
        $meteringPoint->metering_point_id = $data['metering_point_id'];
        $meteringPoint->parent_id = $data['parent_id'];
        $meteringPoint->type_of_mp = $data['type_of_mp'];
        $meteringPoint->settlement_method = $data['settlement_method'];
        $meteringPoint->meter_number = $data['meter_number'];
        $meteringPoint->consumer_c_v_r = $data['consumer_c_v_r'];
        $meteringPoint->data_access_c_v_r = $data['data_access_c_v_r'];
        $meteringPoint->consumer_start_date = $data['consumer_start_date'];
        $meteringPoint->meter_reading_occurrence = $data['meter_reading_occurrence'];
        $meteringPoint->balance_supplier_name = $data['balance_supplier_name'];
        $meteringPoint->street_code = $data['street_code'];
        $meteringPoint->street_name = $data['street_name'];
        $meteringPoint->building_number = $data['building_number'];
        $meteringPoint->floor_id = $data['floor_id'];
        $meteringPoint->room_id = $data['room_id'];
        $meteringPoint->city_name = $data['city_name'];
        $meteringPoint->city_sub_division_name = $data['city_sub_division_name'];
        $meteringPoint->municipality_code = $data['municipality_code'];
        $meteringPoint->location_description = $data['location_description'];
        $meteringPoint->first_consumer_party_name = $data['first_consumer_party_name'];
        $meteringPoint->second_consumer_party_name = $data['second_consumer_party_name'];
        $meteringPoint->hasRelation = $data['hasRelation'];
        $meteringPoint->user_id = $data['user_id'];
        $meteringPoint->created_at = $data['created_at'];
        $meteringPoint->updated_at = $data['updated_at'];

        return $meteringPoint;
    }
}
