<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table        = 'users';
    protected $primaryKey   = 'id_user';
    protected $keyType      = 'string';
    public    $incrementing = false;

    // Tabel Supabase tidak punya updated_at & remember_token
    const UPDATED_AT = null;

    protected $fillable = [
        'id_user',
        'username',
        'password',
        'nama_lengkap',
        'email',
    ];

    protected $hidden = [
        'password',
    ];

    // Jangan cast password sebagai 'hashed' — Auth::attempt() sudah handle verifikasi sendiri
    protected $casts = [];

    // Nonaktifkan remember token karena kolom tidak ada di tabel Supabase
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // tidak disimpan
    }

    public function getRememberTokenName()
    {
        return null;
    }
}
