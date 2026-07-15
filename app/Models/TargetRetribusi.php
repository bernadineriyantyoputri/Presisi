<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetRetribusi extends Model
{
    use HasFactory;

    protected $table = 'target_retribusi';

    protected $fillable = [
        'rincian_id',
        'detail_id',
        'tahun',
        'target_nominal',
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