<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DatahubPriceList.
 * @property string $ChargeOwner
 * @property string $GLN_number
 * @property string $ChargeType
 * @property string $ChargeTypeCode
 * @property string $Note
 * @property string $Description
 * @property Carbon $ValidFrom
 * @property Carbon|null $ValidTo
 * @property string $VATClass
 * @property float $Price1
 * @property float|null $Price2
 * @property float|null $Price3
 * @property float|null $Price4
 * @property float|null $Price5
 * @property float|null $Price6
 * @property float|null $Price7
 * @property float|null $Price8
 * @property float|null $Price9
 * @property float|null $Price10
 * @property float|null $Price11
 * @property float|null $Price12
 * @property float|null $Price13
 * @property float|null $Price14
 * @property float|null $Price15
 * @property float|null $Price16
 * @property float|null $Price17
 * @property float|null $Price18
 * @property float|null $Price19
 * @property float|null $Price20
 * @property float|null $Price21
 * @property float|null $Price22
 * @property float|null $Price23
 * @property float|null $Price24
 * @property int $TransparentInvoicing
 * @property int $TaxIndicator
 * @property string $ResolutionDuration
 * @property Carbon|null $created_at
 * @property Carbon|null $deleted_at
 */
class DatahubPriceList extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = ['ChargeType', 'ChargeTypeCode', 'GLN_number', 'ValidFrom', 'Note'];

    public function getMatchingInDb(): DatahubPriceList|bool
    {
        $db_record = $this->where([
            'GLN_Number'=>$this->getAttribute('GLN_Number'),
            'ChargeType'=>$this->getAttribute('ChargeType'),
            'ChargeTypeCode'=>$this->getAttribute('ChargeTypeCode'),
            'Note'=>$this->getAttribute('Note'),
            'ValidFrom'=>$this->getAttribute('ValidFrom'),
            'ValidTo'=>$this->getAttribute('ValidTo'),
        ])->first();

        if ($db_record) {
            return $this->getAttribute('GLN_Number') == $db_record->GLN_Number
                && $this->getAttribute('ChargeType') == $db_record->ChargeType
                && $this->getAttribute('ChargeTypeCode') == $db_record->ChargeTypeCode
                && $this->getAttribute('Note') == $db_record->Note
                && $this->getAttribute('ValidFrom') == $db_record->ValidFrom
                && $this->getAttribute('ValidTo') == $db_record->ValidTo;
        }

        return false;
    }

    /**
     * @param Builder<DatahubPriceList> $query
     * @return Builder<DatahubPriceList>s
     */
    public function scopeIsValid(Builder $query, Carbon $at): Builder
    {
        return $query->where('ValidFrom', '<=', now())
            ->where(function (Builder $query) use ($at) {
                $query->where('ValidTo', '>=', $at)
                    ->orWhereNull('ValidTo');
            });
    }
}
