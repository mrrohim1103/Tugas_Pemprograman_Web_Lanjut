<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasUuids;

    protected $table = 'visits';
    protected $primaryKey = 'id_visit';
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'waktu_masuk';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'id_guest', 'id_guest');
    }
}
