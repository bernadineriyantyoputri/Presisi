<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LaporanDetail;
use App\Models\LaporanRetribusi;
use App\Models\DetailRetribusi;
use App\Models\PerangkatDaerah;
use App\Models\TargetRetribusi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sevenDaysAgo = now()->subDays(7);
        $tahun = now()->year;

        /*
        |----------------------------------------------------------------
        | RINGKASAN AKTIVITAS (5 kartu)
        |----------------------------------------------------------------
        */

        // 1. Akun Terdaftar Baru (7 hari terakhir)
        $akunBaruCount = PerangkatDaerah::where('created_at', '>=', $sevenDaysAgo)->count();

        // 2. Akun Terverifikasi (yang diverifikasi dalam 7 hari terakhir)
        // status_verifikasi bertipe string ('Terverifikasi' / 'Ditolak'), bukan boolean.
        $akunTerverifikasiCount = PerangkatDaerah::where('status_verifikasi', 'Terverifikasi')
            ->where('tanggal_verifikasi', '>=', $sevenDaysAgo)
            ->count();

        // 3. Laporan Diverifikasi (7 hari terakhir)
        // Catatan: LaporanRetribusi belum punya kolom "diverifikasi_at" tersendiri,
        // jadi dipakai updated_at sebagai proxy waktu perubahan status.
        $laporanDiverifikasiCount = LaporanRetribusi::where('status', 'disetujui')
            ->where('updated_at', '>=', $sevenDaysAgo)
            ->count();

        // 4. Data Retribusi (total data, bukan 7 hari terakhir)
        // ASUMSI: dihitung dari total baris DetailRetribusi (item paling rinci).
        // Ganti ke JenisRetribusi::count() atau RincianRetribusi::count()
        // kalau maksud "Jenis" di sini beda.
        $dataRetribusiCount = DetailRetribusi::count();

        // 5. Target Tercapai (% realisasi vs target aktif, tahun berjalan)
        $targets = TargetRetribusi::where('tahun', $tahun)->get();

        $totalTarget = $targets->sum(function ($t) {
            return $t->target_aktif === 'perubahan'
                ? $t->target_perubahan
                : $t->target_nominal;
        });

        $totalRealisasi = LaporanDetail::whereHas('laporan', function ($q) use ($tahun) {
            $q->where('tahun', $tahun)->where('status', 'disetujui');
        })->sum('total_realisasi');

        $targetPersen = $totalTarget > 0
            ? round(($totalRealisasi / $totalTarget) * 100)
            : 0;

        /*
        |----------------------------------------------------------------
        | AKTIVITAS TERBARU
        |----------------------------------------------------------------
        */

        $aktivitasTerbaru = ActivityLog::latest()->take(5)->get();

        return view('admin.dashboardadmin', compact(
            'akunBaruCount',
            'akunTerverifikasiCount',
            'laporanDiverifikasiCount',
            'dataRetribusiCount',
            'targetPersen',
            'aktivitasTerbaru'
        ));
    }
}