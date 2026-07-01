<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisRetribusi extends Model
{
    protected $table = 'jenis_retribusi';

    protected $fillable = [
        'nama_jenis'
    ];

    public function objekRetribusi()
    {
        return $this->hasMany(ObjekRetribusi::class, 'jenis_id');
    }
}