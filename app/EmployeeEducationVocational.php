<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducationVocational extends Model
{
    protected $table = 'employeeEducationVocational';
    protected $primaryKey = 'educVocationalId';

    protected $fillable = [
        'employeeId',
        'educVocationalSchool',
        'educVocationalAddress',
        'educVocationalCourse',
        'educVocationalYear'
    ];
}
