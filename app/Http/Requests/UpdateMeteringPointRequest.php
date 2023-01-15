<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeteringPointRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'metering_point_id' => 'required|string|max:18',
            'parent_id' => 'sometimes|nullable|max:18',
            'type_of_mp' => 'required|string|max:3',
            'settlement_method' => 'required|string|max:3',
            'meter_number' => 'required|string|max:15',
            'consumer_c_v_r' => 'sometimes|nullable|max:10',
            'data_access_c_v_r' => 'sometimes|nullable|max:10',
            'consumer_start_date' => 'sometimes|date',
            'meter_reading_occurrence' => 'required|string|max:5',
            'balance_supplier_name' => 'required|string',
            'street_code' => 'required|string|max:4',
            'street_name' => 'required|string|max:40',
            'building_number' => 'required|string|max:6',
            'floor_id' => 'sometimes|nullable|max:4',
            'room_id' => 'sometimes|nullable|max:4',
            'city_name' => 'required|string|max:25',
            'city_sub_division_name' => 'sometimes|nullable|max:34',
            'municipality_code' => 'required|string|max:3',
            'location_description' => 'sometimes|nullable|max:132',
            'first_consumer_party_name' => 'sometimes|nullable|max:132',
            'second_consumer_party_name' => 'sometimes|nullable|max:132',
            'hasRelation' => 'required|boolean',
        ];
    }
}
