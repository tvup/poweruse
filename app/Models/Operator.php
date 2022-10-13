<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    public static $operatorName = array(
        5790000705689 => 'Radius Elnet A/S',
        5790000705184 => 'Cerius A/S',
        5790000432752 => 'Energinet Systemansvar A/S (SYO)',
        );

    public static $operatorNumber = array(
        'Radius Elnet A/S' => 5790000705689,
        'Cerius A/S' => 5790000705184,
        'Energinet Systemansvar A/S (SYO)' => 5790000432752,
    );

    public static $gridOperatorArea = array(
        'Radius Elnet A/S' => 'DK2',
        'Cerius A/S' => 'DK2',
    );

}
