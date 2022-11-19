<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Carbon $HourUTC
 * @property Carbon $HourDK
 * @property string $PriceArea
 * @property float $SpotPriceDKK
 * @property float $SpotPriceEUR
 */
class Elspotprices extends Model
{
    use HasFactory;

    public $timestamps = false;
}
