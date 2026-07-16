<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanRetribusi extends Model
{
    protected $table = 'laporan_retribusi';

    protected $fillable = [
        'perangkat_daerah_id',
        'bulan',
        'tahun',
        'tanggal_submit',
        'status'
    ];

    protected $casts = [
        'tanggal_submit' => 'date'
    ];

    public function laporanDetail()
    {
        return $this->hasMany(LaporanDetail::class, 'laporan_id');
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

    public function details()
    {
        return $this->hasMany(LaporanDetail::class, 'laporan_id');
    }
}