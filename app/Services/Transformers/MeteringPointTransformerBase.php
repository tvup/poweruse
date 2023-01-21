<?php

namespace App\Services\Transformers;

use App\Enums\SourceEnum;
use App\Models\MeteringPoint;

class MeteringPointTransformerBase
{
    public function transform(array|MeteringPoint $data, SourceEnum $source): MeteringPoint
    {
        switch ($source) {
            case SourceEnum::DATAHUB:
                return $this->transformDatahubData($data);
            case SourceEnum::EWII:
                return $this->transformEwiiData($data);
            case SourceEnum::POWERUSE:
                return $this->transformPowerUseData($data);
            default:
                throw new \InvalidArgumentException($source->value . ' is not a valid source for this transformation');
        }
    }

    public function prepareForJson(array|MeteringPoint $data): array
    {
        $meteringPoint = [];
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
        $meteringPoint['source'] = SourceEnum::DATAHUB->value;

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

    private function transformEwiiData(array $data): MeteringPoint
    {
        $meteringPoint = app()->make(MeteringPoint::class);
        $meteringPoint->consumer_start_date = $data[0]['Installations'][0]['MoveInDate'];
        $meteringPoint->balance_supplier_name = 'EWII Energi A/S';
        $meteringPoint->street_code = $data[0]['Address']['StreetCode'];
        $meteringPoint->street_name = $data[0]['Address']['Street'];
        $meteringPoint->building_number = $data[0]['Address']['Number'];
        $meteringPoint->floor_id = $data[0]['Address']['Floor'];
        $meteringPoint->room_id = $data[0]['Address']['Side'];
        $meteringPoint->city_name = $data[0]['Address']['City'];
        $meteringPoint->municipality_code = $data[0]['Address']['MunicipalityCode'];
        $meteringPoint->source = SourceEnum::EWII;

        return $meteringPoint;
    }

    private function transformPowerUseData(MeteringPoint $data): MeteringPoint
    {
        return $data;
    }
}
