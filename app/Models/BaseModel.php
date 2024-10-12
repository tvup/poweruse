<?php

namespace App\Models;

use App\Enums\SourceEnum;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = [];

    public const SOURCE = SourceEnum::POWERUSE;
}
