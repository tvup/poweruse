<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $owner
 * @property Carbon $valid_from
 * @property Carbon $valid_to
 * @property string $period_type
 * @property numeric $price
 * @property integer $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property integer $metering_point_id
 * @property ChargePrice[] $chargePrices
 * @property MeteringPoint $meteringPoint
 */
class Charge extends BaseModel
{
    use HasFactory;

    /**
     * @return HasMany<ChargePrice>
     */
    public function chargePrices() : HasMany {
        return $this->hasMany(ChargePrice::class);
    }
}
