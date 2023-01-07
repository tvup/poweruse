<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatahubPriceList extends Model
{
    use HasFactory, SoftDeletes;

    const UPDATED_AT = null;

    protected $guarded = ['created_at', 'deleted_at'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = ['ChargeType', 'ChargeTypeCode', 'Note', 'ValidFrom'];

    protected $fillable = [
        'ChargeOwner'
        ,'GLN_Number'
        ,'ChargeType'
        ,'ChargeTypeCode'
        ,'Note'
        ,'Description'
        ,'ValidFrom'
        ,'ValidTo'
        ,'VATClass'
        ,'Price1'
        ,'Price2'
        ,'Price3'
        ,'Price4'
        ,'Price5'
        ,'Price6'
        ,'Price7'
        ,'Price8'
        ,'Price9'
        ,'Price10'
        ,'Price11'
        ,'Price12'
        ,'Price13'
        ,'Price14'
        ,'Price15'
        ,'Price16'
        ,'Price17'
        ,'Price18'
        ,'Price19'
        ,'Price20'
        ,'Price21'
        ,'Price22'
        ,'Price23'
        ,'Price24'
        ,'TransparentInvoicing'
        ,'TaxIndicator'
        ,'ResolutionDuration'];

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

        if($db_record) {
            return $this->getAttribute('GLN_Number') == $db_record->GLN_Number
                && $this->getAttribute('ChargeType') == $db_record->ChargeType
                && $this->getAttribute('ChargeTypeCode') == $db_record->ChargeTypeCode
                && $this->getAttribute('Note') == $db_record->Note
                && $this->getAttribute('ValidFrom') == $db_record->ValidFrom
                && $this->getAttribute('ValidTo') == $db_record->ValidTo;
        }
        return false;
    }
}
