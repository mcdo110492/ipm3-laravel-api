<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationTertiary extends Model
{
    protected $table = 'employeeEducationTertiary';
    protected $primaryKey = 'educTertiaryId';

    protected $fillable = [
        'employeeId',
        'educTertiarySchool',
        'educTertiaryAddress',
        'educTertiaryCourse',
        'educTertiaryYear'
    ];
}
