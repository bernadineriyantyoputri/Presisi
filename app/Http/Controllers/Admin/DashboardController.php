<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $akunBaruCount = PerangkatDaerah::where('created_at', '>=', $sevenDaysAgo)->count();

        $akunTerverifikasiCount = PerangkatDaerah::where('status_verifikasi', 'Terverifikasi')
            ->where('tanggal_verifikasi', '>=', $sevenDaysAgo)
            ->count();

        $laporanDiverifikasiCount = LaporanRetribusi::where('status', 'disetujui')
            ->where('updated_at', '>=', $sevenDaysAgo)
            ->count();

        $dataRetribusiCount = DetailRetribusi::count();

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

        return view('admin.dashboardadmin', compact(
            'akunBaruCount',
            'akunTerverifikasiCount',
            'laporanDiverifikasiCount',
            'dataRetribusiCount',
            'targetPersen',
        ));
    }
}