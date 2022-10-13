<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GridOperatorNettariffProperty extends Model
{
    use HasFactory;

    public static function getByGLNNumber($glnNumber) {
        return self::where('GLN_number', $glnNumber)->firstOrFail();
    }
}
