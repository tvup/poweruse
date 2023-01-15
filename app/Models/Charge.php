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
 * @property double $price
 * @property integer $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property integer $metering_point_id
 * @property ChargePrice[] $chargePrices
 * @property ChargePrice[] $prices
 * @property MeteringPoint $meteringPoint
 */
class Charge extends BaseModel
{
    use HasFactory;

    protected $appends = ['source'];

    public function getSourceAttribute(): string|null {
        return $this->exists ? self::SOURCE : null;
    }

    /**
     * @return HasMany<ChargePrice>
     */
    public function chargePrices() : HasMany {
        return $this->hasMany(ChargePrice::class);
    }

    /**
     * We need this fake relation as well because the datadefinition for chargePrices on charge is simply called "prices"
     *
     * @return HasMany<ChargePrice>
     */
    public function prices() : HasMany {
        return $this->chargePrices();
    }
}
