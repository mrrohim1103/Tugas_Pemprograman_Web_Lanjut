<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table      = 'vehicles';
    protected $primaryKey = 'id_vehicle';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const UPDATED_AT = null;

    protected $guarded = [];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'id_visit', 'id_visit');
    }
}
