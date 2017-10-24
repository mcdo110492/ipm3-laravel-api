<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';

    protected $primaryKey = 'projectId';

    protected $fillable = [
        'projectCode',
        'projectName'
    ];
}
