<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeHealthInfo extends Model
{
    protected $table = 'employeeHealthInfo';

    protected $primaryKey = 'employeeHealthId';

    protected $fillable = [
        'employeeId',
        'height',
        'weight',
        'bloodType'
    ];
}
