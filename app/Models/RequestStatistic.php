<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestStatistic
 * @package App\Models
 *
 * @property string $verb
 * @property string $endpoint
 * @property int $count
 * @property int $400
 * @property int $401
 * @property int $403
 * @property int $429
 * @property int $500
 * @property int $503
 * @property int $504
 */
class RequestStatistic extends Model
{
    use HasFactory;

    protected $fillable = ['verb','endpoint','count','400','401','403','429','500','503','504'];
}
