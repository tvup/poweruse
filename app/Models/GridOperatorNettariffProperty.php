<?php

namespace App\Models;

class GridOperatorNettariffProperty extends BaseModel
{
    public static function getByGLNNumber(int $glnNumber): GridOperatorNettariffProperty
    {
        return self::where('GLN_number', $glnNumber)->orderBy('id', 'desc')->firstOrFail();
    }
}
