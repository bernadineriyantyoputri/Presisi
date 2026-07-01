<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObjekRetribusi;
use App\Models\RincianRetribusi;

class RincianRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objek = ObjekRetribusi::pluck('id', 'nama_objek');

        RincianRetribusi::insert([

            // ===== Pelayanan Kesehatan =====
            [
                'objek_id' => $objek['Pelayanan Kesehatan'],
                'nama_rincian' => 'Pelayanan Kesehatan di Rumah Sakit Umum Daerah',
            ],
            [
                'objek_id' => $objek['Pelayanan Kesehatan'],
                'nama_rincian' => 'Pelayanan Kesehatan di Tempat Pelayanan Kesehatan Lainnya yang Sejenis',
            ],

            [
                'objek_id' => $objek['Pelayanan Pendidikan'],
                'nama_rincian' => 'Pelayanan Penyelenggaraan Pendidikan dan Pelatihan Teknis',
            ],

            [
                'objek_id' => $objek['Penyedian Tempat Pelelangan'],
                'nama_rincian' => 'Penyediaan Tempat Pelelangan (Dinas Kelautan dan Perikanan)',
            ],

            [
                'objek_id' => $objek['Penyediaan Tempat Khusus Parkir di Luar Badan Jalan'],
                'nama_rincian' => 'Penyediaan Tempat Khusus Parkir di Luar Badan Jalan (Badan Pendapatan Daerah)',
            ],
            [
                'objek_id' => $objek['Penyediaan Tempat Khusus Parkir di Luar Badan Jalan'],
                'nama_rincian' => 'Parkir Khusus Agrowisata Pekalongan (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'objek_id' => $objek['Penyediaan Tempat Khusus Parkir di Luar Badan Jalan'],
                'nama_rincian' => 'Parkir Khusus Agropark (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'objek_id' => $objek['Penyediaan Tempat Khusus Parkir di Luar Badan Jalan'],
                'nama_rincian' => 'Parkir Khusus (Dinas Pemuda dan Olahraga)',
            ],
            [
                'objek_id' => $objek['Penyediaan Tempat Khusus Parkir di Luar Badan Jalan'],
                'nama_rincian' => 'Parkir Khusus (Dinas Perhubungan)',
            ],
            
            [
                'objek_id' => $objek['Pelayanan Jasa Kepelabuhan'],
                'nama_rincian' => 'Pelayanan Jasa Kepelabuhanan "Tambat Labuh" (Dinas Kelautan dan Perikanan)',
            ],
            [
                'objek_id' => $objek['Pelayanan Jasa Kepelabuhan'],
                'nama_rincian' => 'Pelayanan Jasa Kepelabuhanan "Tambat Labuh" (Dinas Perhubungan)',
            ],

            [
                'objek_id' => $objek['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_rincian' => 'Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga ',
            ],
            [
                'objek_id' => $objek['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_rincian' => 'Tempat Rekreasi dan Olahraga (Dinas Kesehatan)',
            ],
            [
                'objek_id' => $objek['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_rincian' => 'Masuk PKK Agropark (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],

            [
                'objek_id' => $objek['Penjualan Hasil Produksi Usaha Pemerintah Daerah'],
                'nama_rincian' => 'Penjualan Hasil Produksi Usaha Pemerintah Daerah',
            ],
            [
                'objek_id' => $objek['Penjualan Hasil Produksi Usaha Pemerintah Daerah'],
                'nama_rincian' => 'Penjualan Hasil Produksi Usaha Pemerintah Daerah Berupa Bibit atau Benih Tanaman',
            ],
             [
                'objek_id' => $objek['Penjualan Hasil Produksi Usaha Pemerintah Daerah'],
                'nama_rincian' => 'Penjualan Produksi hasil Usaha Daerah berupa Bibit Ternak',
            ],
            [
                'objek_id' => $objek['Penjualan Hasil Produksi Usaha Pemerintah Daerah'],
                'nama_rincian' => 'Penjualan Produksi hasil Usaha Daerah berupa Bibit atau Benih Ikan (Dinas Kelautan dan Perikanan',
            ],
            [
                'objek_id' => $objek['Penjualan Hasil Produksi Usaha Pemerintah Daerah'],
                'nama_rincian' => 'Penjualan Produksi hasil Usaha Daerah selain Bibit atau Benih Tanaman, Ternak, dan Ikan',
            ],

            [
                'objek_id' => $objek['Pemanfaatan Aset Daerah'],
                'nama_rincian' => 'Penyewaan Tanah dan Bangunan',
            ],
            [
                'objek_id' => $objek['Pemanfaatan Aset Daerah'],
                'nama_rincian' => 'Penyewaan Bangunan',
            ],
             [
                'objek_id' => $objek['Pemanfaatan Aset Daerah'],
                'nama_rincian' => 'Pemakaian Laboratorium',
            ],
            [
                'objek_id' => $objek['Pemanfaatan Aset Daerah'],
                'nama_rincian' => 'Pemakaian Ruangan',
            ],
             [
                'objek_id' => $objek['Pemanfaatan Aset Daerah'],
                'nama_rincian' => 'Pemakaian Alat',
            ],
 
            [
                'objek_id' => $objek['Retribusi Pengendalian Lalu Lintas'],
                'nama_rincian' => 'Pengendalian Lalu Lintas Penggunaan Kawasan Tertentu (Dinas Perhubungan)',
            ],

            [
                'objek_id' => $objek['Penggunaan Tenaga Kerja Asing (TKA)'],
                'nama_rincian' => 'Penggunaan Tenaga Kerja Asing (Dinas Tenaga Kerja)',
            ],

        ]);
    }
}