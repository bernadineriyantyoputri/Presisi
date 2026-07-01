<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanDetail extends Model
{
    protected $table = 'laporan_detail';

    protected $fillable = [
        'laporan_id',
        'rincian_id',
        'detail_retribusi_id',
        'realisasi_bulan_lalu',
        'realisasi_bulan_ini',
        'total_realisasi',
        'persentase',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanRetribusi::class, 'laporan_id');
    }

    public function rincian()
    {
        return $this->belongsTo(RincianRetribusi::class, 'rincian_id');
    }

    public function detailRetribusi()
    {
        return $this->belongsTo(DetailRetribusi::class, 'detail_retribusi_id');
    }
}