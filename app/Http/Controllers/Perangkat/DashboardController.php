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

        // ----- Status laporan bulan ini -----
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

        // ----- Total laporan tahun ini -----
        $totalLaporanTahunIni = (clone $query)
            ->where('tahun', $tahunIni)
            ->count();

        // ----- Realisasi terhadap target -----
        // Ambil detail laporan (submit/terverifikasi) tahun ini, lalu ambil
        // HANYA laporan bulan terakhir per rincian/detail (karena total_realisasi
        // sudah kumulatif dari bulan-bulan sebelumnya — kalau dijumlah semua
        // bulan akan dobel hitung).
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

        // Ambil target yang BERLAKU SEKARANG untuk tiap rincian/detail yang
        // muncul di atas (bukan pakai target_snapshot yang bisa basi kalau
        // target diubah/di-reset setelah laporan disubmit).
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

        // ----- Laporan terbaru (5 terakhir) -----
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

        // ----- Sapaan berdasarkan jam (WIB, bukan timezone default server) -----
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