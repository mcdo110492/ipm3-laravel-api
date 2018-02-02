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
        'remarks'
    ];


    public function setDateHiredAttribute($value){
        $this->attributes['dateHired'] = Carbon::parse($value);
    }
}
