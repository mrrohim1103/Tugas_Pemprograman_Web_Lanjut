<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table      = 'visits';
    protected $primaryKey = 'id_visit';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const CREATED_AT = 'waktu_masuk';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'id_guest', 'id_guest');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department', 'id_department');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }

    public function purpose()
    {
        return $this->belongsTo(VisitPurpose::class, 'id_purpose', 'id_purpose');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'id_host', 'id_user');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id_visit', 'id_visit');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'id_visit', 'id_visit');
    }
}
