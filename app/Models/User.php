<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'jabatan',
    'no_telepon',
    'foto',
    'unit_kerja',
    'lokasi_kantor',
    'id_pegawai',
    'last_login_at',
];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];
}

    public function perangkatDaerah()
    {
        return $this->hasOne(PerangkatDaerah::class, 'user_id');
    }
}