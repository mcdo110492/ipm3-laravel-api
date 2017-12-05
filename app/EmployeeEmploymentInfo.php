<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeeEmploymentInfo extends Model
{
    protected $table = 'employeeEmploymentInfo';

    protected $primaryKey = 'employeeEmploymentId';

    protected $fillable = [
        'employeeId',
        'positionId',
        'employeeStatusId',
        'employmentStatusId',
        'dateHired',
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

    public function setDateHiredAttribute($value){
        $this->attributes['dateHired'] = Carbon::parse($value);
    }
}
