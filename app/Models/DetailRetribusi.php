<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRetribusi extends Model
{
    protected $table = 'detail_retribusi';

    protected $fillable = [
        'rincian_id',
        'nama_detail'
    ];

    public function rincian()
    {
        return $this->belongsTo(RincianRetribusi::class, 'rincian_id');
    }

    public function laporanDetail()
    {
        return $this->hasMany(LaporanDetail::class, 'detail_retribusi_id');
    }
}