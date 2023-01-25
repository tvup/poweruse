<?php

namespace App\Models;

use App\Enums\SourceEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $metering_point_id
 * @property string $type_of_mp
 * @property string $settlement_method
 * @property string $meter_number
 * @property string $consumer_c_v_r
 * @property string $data_access_c_v_r
 * @property Carbon $consumer_start_date
 * @property string $meter_reading_occurrence
 * @property string $balance_supplier_name
 * @property string $street_code
 * @property string $street_name
 * @property string $building_number
 * @property string $floor_id
 * @property string $room_id
 * @property string $city_name
 * @property string $city_sub_division_name
 * @property string $municipality_code
 * @property string $location_description
 * @property string $first_consumer_party_name
 * @property string $second_consumer_party_name
 * @property bool $hasRelation
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property SourceEnum|null $source
 * @property MeteringPoint[] $children
 * @property User $user
 * @property Charge[] $charges
 */
class MeteringPoint extends BaseModel
{
    use HasFactory;

    protected $appends = ['source'];

    protected $casts = [
        'source' => 'string',
    ];

    public function getSourceAttribute(): ?SourceEnum
    {
        return $this->exists ? self::SOURCE : (array_key_exists('source', $this->attributes) ? $this->attributes['source'] : null);
    }

    public function setSourceAttribute(SourceEnum|string $value): void
    {
        $this->attributes['source'] = $value;
    }

    /**
     * @return BelongsTo<User, MeteringPoint>
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
