<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table      = 'locations';
    protected $primaryKey = 'id_location';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const UPDATED_AT = null;

    protected $guarded = [];

    public function departments()
    {
        return $this->hasMany(Department::class, 'id_location', 'id_location');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'id_location', 'id_location');
    }
}
