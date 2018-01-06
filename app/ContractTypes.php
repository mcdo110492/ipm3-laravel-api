<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class ContractTypes extends Model
{
    protected $table = "contractTypes";
    protected $primaryKey = "contractTypeId";

    protected $fillable = [
        'contractTypeCode',
        'contractTypeName'
    ];
}
