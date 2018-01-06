<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeeCompensations extends Model
{
    protected $table = "employeeCompensations";
    protected $primaryKey = "employeeCompensationId";

    protected $fillable = [
        'employeeId',
        'salaryTypeId',
        'salary',
        'effectiveDate',
        'remarks'
    ];

    public function setEffectiveDateAttribute($value){
        $this->attributes['effectiveDate'] = Carbon::parse($value);
    }
}
