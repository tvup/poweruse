<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $charge_id
 * @property int $position
 * @property float $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Charge $charge
 */
class ChargePrice extends Model
{
    /**
     * @return BelongsTo<Charge, ChargePrice>
     */
    public function charge() : BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }
}
