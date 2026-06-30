<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table      = 'guests';
    protected $primaryKey = 'id_guest';
    protected $keyType    = 'string';
    public    $incrementing = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function visits()
    {
        return $this->hasMany(Visit::class, 'id_guest', 'id_guest');
    }
}
