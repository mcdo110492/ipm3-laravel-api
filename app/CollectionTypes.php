<?php

namespace Ipm;

use Illuminate\Database\Eloquent\Model;

class CollectionTypes extends Model
{
    protected $table = 'collectionTypes';

    protected $primaryKey = 'collectionTypeId';

    protected $fillable = [
        'collectionTypeName',
        'collectionTypeCode'
    ];
}
