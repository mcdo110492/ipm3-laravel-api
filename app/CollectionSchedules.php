<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class CollectionSchedules extends Model
{
    protected $table = 'collectionSchedules';

    protected $primaryKey = 'collectionScheduleId';

    protected $fillable = [
        'collectionScheduleCode',
        'collectionScheduleName'
    ];
}
