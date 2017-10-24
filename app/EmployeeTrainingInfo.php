<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmployeeTrainingInfo extends Model
{
    protected $table = 'employeeTrainingInfo';

    protected $primaryKey = 'employeeTrainingId';

    protected $fillable = [
        'employeeId',
        'trainingName',
        'trainingTitle',
        'trainingFrom',
        'trainingTo'
    ];

    public function setTrainingFromAttribute($value){
        $this->attributes['trainingFrom'] = Carbon::parse($value);
    }

    public function setTrainingToAttribute($value){
        $this->attributes['trainingTo'] = Carbon::parse($value);
    }
}
