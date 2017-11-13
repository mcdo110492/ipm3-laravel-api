<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = "units";

    protected $primaryKey = 'unitId';

    protected $fillable = [
        'unitCode',
        'unitName'
    ];
}   
