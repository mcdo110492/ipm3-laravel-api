<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Shifts extends Model
{
    protected $table = 'shifts';

    protected $primaryKey = 'shiftId';

    protected $fillable = [
        'equipmentId',
        'collectionScheduleId',
        'collectionTypeId',
        'geofenceName',
        'sectors',
        'shiftTime',
        'routeFile',
        'projectId'
    ];


    public function setShiftTimeAttribute($value){
        
        $this->attributes['shiftTime'] = Carbon::parse($value);
                
    }

}
