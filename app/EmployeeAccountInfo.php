<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeAccountInfo extends Model
{
    protected $table = 'employeeAccountInfo';

    protected $primaryKey = 'employeeAccountId';

    protected $fillable = [
        'employeeId',
        'username',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
    ];
}
