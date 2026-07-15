<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianRetribusi extends Model
{
    protected $table = 'rincian_retribusi';

    protected $fillable = [
        'objek_id',
        'nama_rincian'
    ];

    public function objek()
    {
        return $this->belongsTo(ObjekRetribusi::class, 'objek_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailRetribusi::class, 'rincian_id');
    }
    public function target()
{
    return $this->hasMany(TargetRetribusi::class, 'rincian_id');
}
}