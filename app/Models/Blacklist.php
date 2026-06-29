<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $table      = 'blacklists';
    protected $primaryKey = 'id_blacklist';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const UPDATED_AT = null;

    protected $guarded = [];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh', 'id_user');
    }
}
