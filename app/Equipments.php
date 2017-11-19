<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    protected $table = 'equipments';

    protected $primaryKey = 'equipmentId';

    protected $fillable = [
        'equipmentCode',
        'bodyNumber',
        'model',
        'capacity',
        'plateNo',
        'remarks',
        'status',
        'unitId',
        'projectId'
    ];


}
