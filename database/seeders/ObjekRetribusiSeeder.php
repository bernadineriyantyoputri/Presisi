<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObjekRetribusi;

class ObjekRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ObjekRetribusi::insert([

            [
                'jenis_id' => 1,
                'nama_objek' => 'Pelayanan Kesehatan',
            ],
            [
                'jenis_id' => 1,
                'nama_objek' => 'Pelayanan Pendidikan',
            ],

            [
                'jenis_id' => 2,
                'nama_objek' => 'Penyedian Tempat Pelelangan',
            ],
            [
                'jenis_id' => 2,
                'nama_objek' => 'Penyediaan Tempat Khusus Parkir di Luar Badan Jalan',
            ],
            [
                'jenis_id' => 2,
                'nama_objek' => 'Pelayanan Jasa Kepelabuhan',
            ],
            [
                'jenis_id' => 2,
                'nama_objek' => 'Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga ',
            ],
            [
                'jenis_id' => 2,
                'nama_objek' => 'Penjualan Hasil Produksi Usaha Pemerintah Daerah',
            ],
            [
                'jenis_id' => 2,
                'nama_objek' => 'Pemanfaatan Aset Daerah',
            ],
           
            [
                'jenis_retribusi_id' => 3,
                'nama_objek' => 'Retribusi Pengendalian Lalu Lintas',
            ],
            [
                'jenis_retribusi_id' => 3,
                'nama_objek' => 'Penggunaan Tenaga Kerja Asing (TKA)',
            ],

        ]);
    }
}