<?php

namespace App\Services\Transformers\Facades;

use App\Enums\SourceEnum;
use App\Models\MeteringPoint;
use Illuminate\Support\Facades\Facade;

/**
 * @method static transform(array|MeteringPoint $meteringPoint, SourceEnum $sourceEnum)
 * @method static prepareForJson(MeteringPoint $meteringPoint)
 */
class MeteringPointTransformer extends Facade
{
    public string $metering_point_id;

    public string $id;

    protected static function getFacadeAccessor(): string
    {
        return 'metering_point_transformer';
    }
}
