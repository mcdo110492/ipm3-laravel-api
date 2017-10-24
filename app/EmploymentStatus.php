<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    protected $table = 'employmentStatus';

    protected $primaryKey = 'employmentStatusId';

    protected $fillable = [
        'employmentStatusName'
    ];
}
