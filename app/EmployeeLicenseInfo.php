<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeeLicenseInfo extends Model
{
    protected $table = 'employeeLicenseInfo';

    protected $primaryKey = 'employeeLicenseId';

    protected $fillable = [
        'employeeId',
        'licenseNumber',
        'licenseType',
        'dateIssued',
        'dateExpiry',
        'licenseImage'
    ];


    public function setDateIssuedAttribute($value){
        $this->attributes['dateIssued'] = Carbon::parse($value);
    }

    public function setDateExpiryAttribute($value){
        $this->attributes['dateExpiry'] = Carbon::parse($value);
    }

    
}
