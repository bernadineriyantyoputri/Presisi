<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetRetribusiSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = 2026;

        // Seed tetap supaya angka reproducible tiap kali dijalankan ulang
        mt_srand(42);

        $rincians = DB::table('rincian_retribusi')->get();
        $allDetails = DB::table('detail_retribusi')->get()->groupBy('rincian_id');

        $now = now();
        $rows = [];

        foreach ($rincians as $rincian) {
            $details = $allDetails->get($rincian->id);

            if ($details && $details->isNotEmpty()) {
                // Rincian punya detail -> 1 target per detail
                foreach ($details as $detail) {
                    $rows[] = [
                        'detail_id'      => $detail->id,
                        'rincian_id'     => $rincian->id,
                        'tahun'          => $tahun,
                        'target_nominal' => mt_rand(50, 500) * 1_000_000,
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                }
            } else {
                // Rincian TIDAK punya detail sama sekali -> tetap dibuatkan
                // 1 baris target, dengan detail_id kosong (null)
                $rows[] = [
                    'detail_id'      => null,
                    'rincian_id'     => $rincian->id,
                    'tahun'          => $tahun,
                    'target_nominal' => mt_rand(50, 500) * 1_000_000,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ];
            }
        }

        if (empty($rows)) {
            $this->command->warn('Tidak ada data untuk di-seed.');
            return;
        }

        // Catatan: upsert dengan unique key (detail_id, tahun) aman untuk
        // banyak baris ber-detail_id NULL, karena di PostgreSQL setiap NULL
        // dianggap berbeda satu sama lain (tidak dianggap duplicate).
        DB::table('target_retribusi')->upsert(
            $rows,
            ['detail_id', 'tahun'],
            ['rincian_id', 'target_nominal', 'updated_at']
        );

        $this->command->info('Berhasil seed ' . count($rows) . ' target retribusi untuk tahun ' . $tahun);
    }
}