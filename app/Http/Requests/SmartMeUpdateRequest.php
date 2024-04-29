<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmartMeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['string', 'max:255'],
            'password' => ['string', 'max:255'],
            'directory_id' => ['string', 'max:255'],
        ];
    }
}
