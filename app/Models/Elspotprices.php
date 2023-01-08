<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property int $id
 * @property Carbon $HourUTC
 * @property Carbon $HourDK
 * @property string $PriceArea
 * @property float $SpotPriceDKK
 * @property float $SpotPriceEUR
 */
class Elspotprices extends BaseModel
{
    public $timestamps = false;
}
