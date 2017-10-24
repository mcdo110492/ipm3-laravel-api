<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationInfo extends Model
{
    protected $table = 'employeeEducationInfo';

    protected $primaryKey = 'employeeEducationId';

    protected $fillable = [
        'employeeId',
        'schoolName',
        'schoolAddress',
        'schoolYear',
        'degree',
        'major',
        'minor',
        'awards'
    ];
}
