<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class SalaryTypes extends Model
{
    protected $table = "salaryTypes";
    protected $primaryKey = "salaryTypeId";

    protected $fillable = [
        'salaryTypeCode',
        'salaryTypeName'
    ];
}
