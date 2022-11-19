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
 */
class RequestStatistic extends Model
{
    use HasFactory;

    protected $fillable = ['verb','endpoint','count','400','401','403','429','500','503','504'];
}
