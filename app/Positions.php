<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';

    protected $primaryKey = 'positionId';

    protected $fillable = [
        'positionName',
        'positionCode'
    ];
}
