<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestCategory extends Model
{
    protected $table      = 'guest_categories';
    protected $primaryKey = 'id_category';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $guarded = [];
}
