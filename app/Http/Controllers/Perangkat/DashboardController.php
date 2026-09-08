<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanRetribusi;
use App\Models\TargetRetribusi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $perangkatDaerah = $user->perangkatDaerah;

        if (!$perangkatDaerah) {
            abort(403, 'Data perangkat daerah tidak ditemukan untuk akun ini.');
        }

        $query = LaporanRetribusi::where('perangkat_daerah_id', $perangkatDaerah->id);

        $bulanIni = now()->format('n');
        $tahunIni = now()->format('Y');

        $laporanBulanIni = (clone $query)
            ->where('bulan', $bulanIni)
            ->where('tahun', $tahunIni)
            ->first();

        $statusLaporanBulanIni = match (true) {
            !$laporanBulanIni => 'Belum submit',
            $laporanBulanIni->status === 'submit' => 'Sudah submit',
            default => 'Draft',
        };

        $totalLaporanTahunIni = (clone $query)
            ->where('tahun', $tahunIni)
            ->count();

        $detailTerbaruPerItem = (clone $query)
            ->where('tahun', $tahunIni)
            ->whereIn('status', ['submit', 'terverifikasi'])
            ->with('details')
            ->orderByDesc('bulan')
            ->get()
            ->pluck('details')
            ->flatten()
            ->unique(fn ($d) => $d->rincian_id . '-' . $d->detail_retribusi_id);

        $totalRealisasi = $detailTerbaruPerItem->sum('total_realisasi');

        $targetList = TargetRetribusi::where('tahun', $tahunIni)->get()
            ->keyBy(fn ($t) => $t->rincian_id . '-' . ($t->detail_id ?? 'null'));

        $totalTarget = $detailTerbaruPerItem->sum(function ($d) use ($targetList) {
            $key = $d->rincian_id . '-' . ($d->detail_retribusi_id ?? 'null');
            $target = $targetList->get($key);

            if (!$target) {
                return 0;
            }

            return $target->target_aktif === 'perubahan'
                ? ($target->target_perubahan ?? 0)
                : ($target->target_nominal ?? 0);
        });

        $realisasiTarget = $totalTarget > 0
            ? round(($totalRealisasi / $totalTarget) * 100, 2)
            : 0;

        $laporanTerbaru = (clone $query)
            ->withSum('laporanDetail as jumlah', 'total_realisasi')
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

        $jam = now()->timezone('Asia/Jakarta')->format('H');
        $sapaan = match (true) {
            $jam < 11 => 'Selamat Pagi',
            $jam < 15 => 'Selamat Siang',
            $jam < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
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