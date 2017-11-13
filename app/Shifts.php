<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

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
}
