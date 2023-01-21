<?php

namespace App\Enums;

enum SourceEnum:string
{
    case DATAHUB = 'DATAHUB';
    case EWII = 'EWII';
    case POWERUSE = 'POWERUSE';
    case SMARTME = 'SMART_ME';
}
