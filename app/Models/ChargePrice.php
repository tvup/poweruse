<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property integer $charge_id
 * @property integer $position
 * @property numberic $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Charge $charge
 *
 */
class ChargePrice extends Model
{
    use HasFactory;
}
