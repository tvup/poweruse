<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChargeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'owner' => 'required',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date',
            'period_type' => 'required|string|max:5',
            'price' => 'nullable|string',
            'quantity' => 'nullable|string|max:4',
        ];
    }
}
