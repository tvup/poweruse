<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $year
 * @property string $chargeGroup1
 * @property string $chargeGroup2
 * @property string $grid_operator_gln
 * @property string $gridOperatorName
 * @property int $numberOfMeteringPoints
 * @property int $consumptionKwh
 */
class ChargeGroup extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'charge_group_1', 'charge_group_2', 'grid_operator_gln', 'grid_operator_name', 'number_of_metering_points','consumption_kwh'];
}
