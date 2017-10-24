<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeeClubInfo extends Model
{
    protected $table = 'employeeClubInfo';

    protected $primaryKey = 'employeeClubId';

    protected $fillable = [
        'employeeId',
        'clubName',
        'clubPosition',
        'membershipDate'
    ];

    public function setMembershipDateAttribute($value){
        $this->attributes['membershipDate'] = Carbon::parse($value);
    }
}

