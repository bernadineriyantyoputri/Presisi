<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanRetribusi;
use App\Models\PerangkatDaerah;

class LaporanRetribusiSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PerangkatDaerah::all() as $perangkat) {

            LaporanRetribusi::firstOrCreate(
                [
                    'perangkat_daerah_id' => $perangkat->id,
                ],
                [
                    'bulan' => 6,
                    'tahun' => 2026,
                    'tanggal_submit' => now(),
                    'status' => 'submit',
                ]
            );

        }
    }
}