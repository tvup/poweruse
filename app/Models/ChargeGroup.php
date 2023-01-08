<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $year
 * @property string $charge_group_1
 * @property string $charge_group_2
 * @property string $grid_operator_gln
 * @property string $grid_operator_name
 * @property int $number_of_metering_points
 * @property int $consumption_kwh
 */
class ChargeGroup extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'charge_group_1', 'charge_group_2', 'grid_operator_gln', 'grid_operator_name', 'number_of_metering_points','consumption_kwh'];
}
