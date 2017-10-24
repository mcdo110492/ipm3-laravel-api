<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmploymentInfo extends Model
{
    protected $table = 'employeeEmploymentInfo';

    protected $primaryKey = 'employeeEmploymentId';

    protected $fillable = [
        'employeeId',
        'positionId',
        'employeeStatusId',
        'employmentStatusId',
        'contractStart',
        'contractEnd',
        'salary',
        'remarks'
    ];

    public function setContractStartAttribute($value){
        $this->attributes['contractStart'] = Carbon::parse($value);
    }

    public function setContractEndAttribute($value){
        $this->attributes['contractEnd'] = Carbon::parse($value);
    }
}
