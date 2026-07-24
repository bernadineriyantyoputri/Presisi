<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'type',
        'aktivitas',
        'detail',
        'icon',
        'icon_color',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor supaya bisa dipakai di blade sebagai $item['waktu']
     * (format: 21 Jul 2026, 10:15) tanpa perlu ubah view dashboard.
     */
    public function getWaktuAttribute(): string
    {
        return $this->created_at->translatedFormat('d M Y, H:i');
    }

    /**
     * Helper generik. Panggil ini dari controller manapun setelah
     * sebuah aksi berhasil dilakukan.
     *
     * Contoh:
     *   ActivityLog::log([
     *       'type'       => 'akun_verifikasi',
     *       'aktivitas'  => 'Akun admin diverifikasi',
     *       'detail'     => $perangkat->nama_perangkat,
     *       'icon'       => 'bi-person-check-fill',
     *       'icon_color' => 'blue',
     *       'status'     => 'Selesai',
     *   ]);
     */
    public static function log(array $data): self
    {
        return static::create(array_merge([
            'user_id' => Auth::id(),
            'status'  => 'Selesai',
        ], $data));
    }

    /* =========================================================
       Shortcut method untuk jenis-jenis aktivitas yang sudah
       diketahui di aplikasi ini. Tinggal panggil salah satu ini
       di controller terkait — lebih ringkas dan konsisten
       dibanding menulis array manual tiap kali.
    ========================================================= */

    public static function akunBaruDidaftarkan(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'akun_baru',
            'aktivitas'  => 'Akun baru didaftarkan',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-check-circle-fill',
            'icon_color' => 'green',
            'status'     => 'Selesai',
        ]);
    }

    public static function akunDiverifikasi(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'akun_verifikasi',
            'aktivitas'  => 'Akun admin diverifikasi',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-person-check-fill',
            'icon_color' => 'blue',
            'status'     => 'Selesai',
        ]);
    }

    public static function akunDitolak(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'akun_ditolak',
            'aktivitas'  => 'Permohonan akun ditolak',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-person-x-fill',
            'icon_color' => 'orange',
            'status'     => 'Selesai',
        ]);
    }

    public static function akunDiaktifkanKembali(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'akun_aktif',
            'aktivitas'  => 'Akun diaktifkan kembali',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-person-check-fill',
            'icon_color' => 'blue',
            'status'     => 'Selesai',
        ]);
    }

    public static function akunDinonaktifkan(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'akun_nonaktif',
            'aktivitas'  => 'Akun dinonaktifkan',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-person-x-fill',
            'icon_color' => 'orange',
            'status'     => 'Selesai',
        ]);
    }

    public static function laporanDiverifikasi(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'laporan_verifikasi',
            'aktivitas'  => 'Laporan retribusi diverifikasi',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-file-earmark-text-fill',
            'icon_color' => 'purple',
            'status'     => 'Selesai',
        ]);
    }

    public static function laporanDitolak(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'laporan_ditolak',
            'aktivitas'  => 'Laporan retribusi ditolak',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-file-earmark-x-fill',
            'icon_color' => 'orange',
            'status'     => 'Selesai',
        ]);
    }

    public static function laporanMenungguVerifikasi(string $namaPerangkat): self
    {
        return static::log([
            'type'       => 'laporan_pending',
            'aktivitas'  => 'Laporan menunggu verifikasi',
            'detail'     => $namaPerangkat,
            'icon'       => 'bi-file-earmark-text-fill',
            'icon_color' => 'purple',
            'status'     => 'Proses',
        ]);
    }

    public static function dataRetribusiDitambahkan(string $namaItem): self
    {
        return static::log([
            'type'       => 'data_retribusi',
            'aktivitas'  => 'Data retribusi ditambahkan',
            'detail'     => $namaItem,
            'icon'       => 'bi-database-fill',
            'icon_color' => 'orange',
            'status'     => 'Selesai',
        ]);
    }
}