<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationHighest extends Model
{
    protected $table = 'employeeEducationHighest';
    protected $primaryKey = 'educHighestId';

    protected $fillable = [
        'employeeId',
        'educHighestSchool',
        'educHighestAddress',
        'educHighestCourse',
        'educHighestYear'
    ];
}
