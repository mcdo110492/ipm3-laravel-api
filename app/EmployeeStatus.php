<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeStatus extends Model
{
    protected $table = 'employeeStatus';

    protected $primaryKey = 'employeeStatusId';

    protected $fillable = [
        'employeeStatusName',
        'employeeStatusCode'
    ];
}
