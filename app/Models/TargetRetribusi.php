<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetRetribusi extends Model
{
    use HasFactory;

    protected $table = 'target_retribusi';

    protected $fillable = [
        'detail_id',
        'rincian_id',
        'tahun',
        'target_nominal',
        'target_perubahan',
    ];

    public function rincian()
    {
        return $this->belongsTo(RincianRetribusi::class, 'rincian_id');
    }

    public function detail()
    {
        return $this->belongsTo(DetailRetribusi::class, 'detail_id');
    }
}