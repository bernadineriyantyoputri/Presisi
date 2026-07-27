<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanRetribusi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // User TIDAK punya perangkat_daerah_id langsung.
        // Relasinya: users -(1)- perangkat_daerah -(banyak)- laporan_retribusi
        $perangkatDaerah = $user->perangkatDaerah;

        if (!$perangkatDaerah) {
            abort(403, 'Data perangkat daerah tidak ditemukan untuk akun ini.');
        }

        $query = LaporanRetribusi::where('perangkat_daerah_id', $perangkatDaerah->id);

        // ----- Status laporan bulan ini -----
        $bulanIni = now()->format('n');
        $tahunIni = now()->format('Y');

        $laporanBulanIni = (clone $query)
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->first();

        // ⚠️ status di database cuma 'draft' / 'submit' (belum ada status
        // "terverifikasi"). Sesuaikan lagi kalau verifikasi disimpan di
        // tempat lain (misal tabel/kolom terpisah).
        $statusLaporanBulanIni = match (true) {
            !$laporanBulanIni => 'Belum submit',
            $laporanBulanIni->status === 'submit' => 'Sudah submit',
            default => 'Draft',
        };

        // ----- Total laporan tahun ini -----
        $totalLaporanTahunIni = (clone $query)
            ->where('tahun', $tahunIni)
            ->count();

        // ----- Realisasi terhadap target -----
        // ⚠️ BELUM DIISI: masih menunggu struktur tabel target_retribusi
        // supaya perhitungan persennya akurat.
        $realisasiTarget = 0;

        // ----- Laporan terbaru (5 terakhir), sekalian jumlah dari laporan_detail -----
        $laporanTerbaru = (clone $query)
            ->withSum('laporanDetail as jumlah', 'total_realisasi') // ⚠️ pastikan relasi laporanDetail() ada di model LaporanRetribusi
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->take(5)
            ->get()
            ->map(function ($laporan) {
                $laporan->jumlah = $laporan->jumlah ?? 0;
                $laporan->bulan = \Carbon\Carbon::createFromDate(null, $laporan->bulan, 1)
                    ->translatedFormat('F');
                return $laporan;
            });

        // ----- Sapaan berdasarkan jam -----
        $jam = now()->format('H');
        $sapaan = match (true) {
            $jam < 11 => 'Selamat pagi',
            $jam < 15 => 'Selamat siang',
            $jam < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };

        return view('perangkat.dashboard', [
            'akun' => $user,
            'namaInstansi' => $perangkatDaerah->nama_perangkat,
            'sapaan' => $sapaan,
            'statusLaporanBulanIni' => $statusLaporanBulanIni,
            'totalLaporanTahunIni' => $totalLaporanTahunIni,
            'realisasiTarget' => $realisasiTarget,
            'laporanTerbaru' => $laporanTerbaru,
        ]);
    }
}