<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatDaerah extends Model
{
    protected $table = 'perangkat_daerah';

    protected $fillable = [
        'user_id',
        'nama_perangkat',
        'kepala_perangkat',
        'pangkat_golongan',
        'nip',
        'bendahara_penerimaan',
        'no_hp',
        'email',
        'status_verifikasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     public function laporan()
    {
        return $this->hasMany(LaporanRetribusi::class);
    }
}