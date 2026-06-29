<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table      = 'rooms';
    protected $primaryKey = 'id_room';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const UPDATED_AT = null;

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }
}
