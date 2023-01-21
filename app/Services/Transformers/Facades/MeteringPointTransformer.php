<?php

namespace App\Services\Transformers\Facades;

use App\Enums\SourceEnum;
use App\Models\MeteringPoint;
use Illuminate\Support\Facades\Facade;

/**
 * @method static transform(array $response, SourceEnum $sourceEnum)
 * @method static prepareForJson(MeteringPoint $response)
 */
class MeteringPointTransformer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'metering_point_transformer';
    }
}
