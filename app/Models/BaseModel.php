<?php

namespace App\Models;

use App\Enums\SourceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const SOURCE = SourceEnum::POWERUSE;
}
