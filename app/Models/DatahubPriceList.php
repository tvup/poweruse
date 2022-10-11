<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatahubPriceList extends Model
{
    use HasFactory, SoftDeletes;

    const UPDATED_AT = null;

    protected $guarded = ['created_at', 'deleted_at'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = ['GLN_Number', 'ChargeType', 'ChargeTypeCode', 'Note', 'ValidFrom', 'ValidTo'];
}
