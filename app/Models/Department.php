<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasUuids;

    protected $table = 'departments';
    protected $primaryKey = 'id_department';
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function visits()
    {
        return $this->hasMany(Visit::class, 'id_department', 'id_department');
    }
}
