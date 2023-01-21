<?php

namespace App\Services\Transformers;

use App\Models\MeteringPoint;

class MeteringPointTransformerBase
{
    public function transform(array|MeteringPoint $data, string $source): MeteringPoint
    {
        switch ($source) {
            case 'DATAHUB':
                return $this->transformDatahubData($data);
            case 'EWII':
                return $this->transformEwiiData($data);
            case 'POWERUSE':
                return $this->transformPowerUseData($data);
            default:
                throw new \InvalidArgumentException($source . ' is not a valid source for this transformation');
        }
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
        //$meteringPoint->metering_point_id = $data['meteringPointId'];
        //$meteringPoint->type_of_mp = $data['typeOfMP'];
        //$meteringPoint->settlement_method = $data['settlementMethod'];
        //$meteringPoint->meter_number = $data['meterNumber'];
        //$meteringPoint->consumer_c_v_r = $data['consumerCVR'];
        //$meteringPoint->data_access_c_v_r = $data['dataAccessCVR'];
        $meteringPoint->consumer_start_date = $data[0]['Installations'][0]['MoveInDate'];
        //$meteringPoint->meter_reading_occurrence = $data['meterReadingOccurrence'];
        $meteringPoint->balance_supplier_name = 'EWII Energi A/S';
        $meteringPoint->street_code = $data[0]['Address']['StreetCode'];
        $meteringPoint->street_name = $data[0]['Address']['Street'];
        $meteringPoint->building_number = $data[0]['Address']['Number'];
        $meteringPoint->floor_id = $data[0]['Address']['Floor'];
        $meteringPoint->room_id = $data[0]['Address']['Side'];
        $meteringPoint->city_name = $data[0]['Address']['City'];
        //$meteringPoint->city_sub_division_name = $data['citySubDivisionName'];
        $meteringPoint->municipality_code = $data[0]['Address']['MunicipalityCode'];
        //$meteringPoint->location_description = $data['locationDescription'];
        //$meteringPoint->first_consumer_party_name = $data['firstConsumerPartyName'];
        //$meteringPoint->second_consumer_party_name = $data['secondConsumerPartyName'];
        //$meteringPoint->hasRelation = $data['hasRelation'];
        $meteringPoint->source = 'EWII';

        return $meteringPoint;
    }

    private function transformPowerUseData(MeteringPoint $data): MeteringPoint
    {
        return $data;
    }
}
