<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjekRetribusi extends Model
{
    protected $table = 'objek_retribusi';

    protected $fillable = [
        'jenis_id',
        'nama_objek'
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisRetribusi::class, 'jenis_id');
    }

    public function rincian()
    {
        return $this->hasMany(RincianRetribusi::class, 'objek_id');
    }
}