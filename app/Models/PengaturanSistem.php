<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'nama_sistem',
        'tahun_anggaran_aktif',
        'teks_footer',
        'logo_sistem',
        'logo_bapenda',
        'notif_laporan_masuk',
        'notif_target_belum_tercapai',
        'notif_perubahan_data',
        'notif_pengingat_laporan',
    ];

    protected $casts = [
        'notif_laporan_masuk'         => 'boolean',
        'notif_target_belum_tercapai' => 'boolean',
        'notif_perubahan_data'        => 'boolean',
        'notif_pengingat_laporan'     => 'boolean',
    ];

    /**
     * Ambil satu-satunya row pengaturan. Kalau belum ada, buat default.
     */
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}