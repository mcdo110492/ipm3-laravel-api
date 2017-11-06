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

    public function setFirstNameAttribute($value) {

        $this->attributes['firstName'] = ucfirst($value);       

    }

    public function setMiddleNameAttribute($value) {
        
        $this->attributes['middleName'] = ucfirst($value);       
        
    }

    public function setLastNameAttribute($value){

        $this->attributes['lastName']   =   ucfirst($value);

    }

}
