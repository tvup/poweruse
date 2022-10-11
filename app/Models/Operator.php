<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    public static $operatorName = array(
        5790000705689 => 'Radius Elnet A/S',
        );

    public static $operatorNumber = array(
        'Radius Elnet A/S' => 5790000705689,
    );
}
