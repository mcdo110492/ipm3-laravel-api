<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationSecondary extends Model
{
    protected $table = 'employeeEducationSecondary';
    protected $primaryKey = 'educSecondaryId';

    protected $fillable = [
        'employeeId',
        'educSecondarySchool',
        'educSecondaryAddress',
        'educSecondaryYear'
    ];
}
