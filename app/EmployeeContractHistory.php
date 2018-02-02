<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class EmployeeContractHistory extends Model
{
    protected $table = "employeeContractHistory";

    protected $primaryKey = "employeeContractId";

    protected $fillable = [
        'employeeId',
        'contractStart',
        'contractEnd',
        'contractExtension',
        'contractTypeId',
        'remarks'
    ];

    public function setContractStartAttribute($value){
        $this->attributes['contractStart'] = Carbon::parse($value);
    }

    public function setContractEndAttribute($value){
        $this->attributes['contractEnd'] = Carbon::parse($value);
    }

    public function setContractExtensionAttribute($value){
        $this->attributes['contractExtension'] = ($value !== null) ? Carbon::parse($value) : NULL ;
    }
}
