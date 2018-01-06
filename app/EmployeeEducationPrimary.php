<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationPrimary extends Model
{
    protected $table = 'employeeEducationPrimary';
    protected $primaryKey = 'educPrimaryId';

    protected $fillable = [
        'educPrimarySchool',
        'educPrimaryAddress',
        'educPrimaryYear',
        'employeeId'
    ];
}
