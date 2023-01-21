<?php

namespace App\Services\Transformers\Facades;

use Illuminate\Support\Facades\Facade;

class MeteringPointTransformer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'metering_point_transformer';
    }
}
