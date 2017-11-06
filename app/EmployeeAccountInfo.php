<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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


    public function setPasswordAttribute($value) {

        $this->attributes['password']    =   Hash::make($value);

    }
}
