<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeTariffMapping extends Model
{
    protected $fillable = [
        'charge_name',
        'charge_owner_gln',
        'datahub_note',
        'datahub_gln',
        'datahub_charge_type',
        'datahub_description',
        'verified',
    ];

    protected function casts(): array
    {
        return [
            'verified' => 'boolean',
        ];
    }
}
