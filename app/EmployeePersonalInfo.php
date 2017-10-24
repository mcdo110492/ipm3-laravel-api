<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeePersonalInfo extends Model
{
    protected $table = 'employeePersonalInfo';

    protected $primaryKey = 'employeeId';

    protected $fillable = [
        'employeeNumber',
        'firstName',
        'middleName',
        'lastName',
        'birthday',
        'placeOfBirth',
        'civilStatus',
        'citizenship',
        'religion',
        'projectId'
    ];

    public function setBirthdayAttribute($value){

        $this->attributes['birthday'] = Carbon::parse($value);
        
    }

}
