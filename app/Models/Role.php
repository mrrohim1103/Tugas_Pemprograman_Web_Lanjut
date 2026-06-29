<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id_role';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const UPDATED_AT = null;

    protected $guarded = [];
}
