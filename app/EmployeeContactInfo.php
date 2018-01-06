<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeContactInfo extends Model
{
    protected $table = 'employeeContactInfo';

    protected $primaryKey = 'employeeContactId';

    protected $fillable = [
        'employeeId',
        'presentAddress',
        'provincialAddress',
        'primaryMobileNumber',
        'secondaryMobileNumber',
        'telephoneNumber'
    ];
}
