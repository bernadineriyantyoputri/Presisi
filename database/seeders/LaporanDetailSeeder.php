<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanDetail;
use App\Models\LaporanRetribusi;
use App\Models\DetailRetribusi;

class LaporanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $laporans = LaporanRetribusi::all();

        foreach ($laporans as $laporan) {

            foreach (DetailRetribusi::all() as $detail) {

                $bulanLalu = rand(5000000, 50000000);
                $bulanIni  = rand(5000000, 50000000);
                $total     = $bulanLalu + $bulanIni;

                // Contoh target agar persentase tidak selalu 100%
                $target = rand(80000000, 150000000);

                $persentase = round(($total / $target) * 100, 2);

                LaporanDetail::updateOrCreate(
                    [
                        'laporan_id' => $laporan->id,
                        'detail_retribusi_id' => $detail->id,
                    ],
                    [
                        'rincian_id' => $detail->rincian_id,
                        'realisasi_bulan_lalu' => $bulanLalu,
                        'realisasi_bulan_ini' => $bulanIni,
                        'total_realisasi' => $total,
                        'persentase' => $persentase,
                    ]
                );
            }
        }
    }
}