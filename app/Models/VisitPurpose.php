<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitPurpose extends Model
{
    protected $table      = 'visit_purposes';
    protected $primaryKey = 'id_purpose';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $guarded = [];
}
