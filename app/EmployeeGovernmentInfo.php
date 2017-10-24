<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeGovernmentInfo extends Model
{
    protected $table = 'employeeGovernmentInfo';

    protected $primaryKey = 'employeeGovernmentId';

    protected $fillable = [
        'employeeId',
        'sssNumber',
        'philHealthNumber',
        'pagIbigNumber',
        'tinNumber'
    ];
}
