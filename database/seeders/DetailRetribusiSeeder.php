<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RincianRetribusi;
use App\Models\DetailRetribusi;

class DetailRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rincian = RincianRetribusi::pluck('id', 'nama_rincian');

        DetailRetribusi::insert([

            [
                'rincian_id' => $rincian['Pelayanan Kesehatan di Rumah Sakit Umum Daerah'],
                'nama_detail' => 'BLUD Rumah Sakit Umum Daerah Abdul Moeloek',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Kesehatan di Rumah Sakit Umum Daerah'],
                'nama_detail' => 'BLUD Rumah Sakit Umum Daerah Bandar Negara Husada',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Kesehatan di Rumah Sakit Umum Daerah'],
                'nama_detail' => 'BLUD Rumah Sakit Umum Daerah Abdul Moeloek',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Kesehatan di Tempat Pelayanan Kesehatan Lainnya yang Sejenis'],
                'nama_detail' => 'UPTD Instalasi Farmasi dan Kalibrasi (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Kesehatan di Tempat Pelayanan Kesehatan Lainnya yang Sejenis'],
                'nama_detail' => 'BLUD Rumah Sakit Jiwa',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Penyelenggaraan Pendidikan dan Pelatihan Teknis'],
                'nama_detail' => 'BLUD Dinas Pendidikan dan Kebudayaan',
            ],

            [
                'rincian_id' => $rincian['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_detail' => 'UPTD Tahura Wan Abdurahman (Dinas Kehutanan)',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_detail' => 'UPTD Musium Ketransmigrasian (Dinas Pendidikan dan Kebudayaan)',
            ],
            [
                'rincian_id' => $rincian['Pelayanan Tempat Rekreasi, Pariwisata dan Ekonomi Kreatif dan Olahraga '],
                'nama_detail' => 'UPTD Meseum Negeri Ruwa Jurai (Dinas Pendidikan dan Kebudayaan)',
            ],
            [
                'rincian_id' => $rincian['Penjualan Hasil Produksi Usaha Pemerintah Daerah Berupa Bibit atau Benih Tanaman'],
                'nama_detail' => 'UPTD BBI Holtikultura dan Lahan Kering (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penjualan Hasil Produksi Usaha Pemerintah Daerah Berupa Bibit atau Benih Tanaman'],
                'nama_detail' => 'UPTD BBI Tanaman Pangan dan Alsintan (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',

            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah berupa Bibit Ternak'],
                'nama_detail' => 'UPTD Balai Inseminasi Buatan / Mani Beku Ternak Sapi (Dinas Peternakan dan Kesehatan Hewan)',

            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah berupa Bibit Ternak'],
                'nama_detail' => 'UPTD Balai Pembibitan Ternak & Pekan (Dinas Peternakan dan Kesehatan Hewan)',

            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah berupa Bibit Ternak'],
                'nama_detail' => 'Jasa Penjualan Ternak Bibit Kambing',

            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah berupa Bibit Ternak'],
                'nama_detail' => 'Jasa Penjualan Ternak Bibit Sapi',
            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah selain Bibit atau Benih Tanaman, Ternak, dan Ikan'],
                'nama_detail' => 'UPTD Balai Benih Kebun Induk (BB/KI) Dinas Perkebunan',
            ],
            [
                'rincian_id' => $rincian['Penjualan Produksi hasil Usaha Daerah selain Bibit atau Benih Tanaman, Ternak, dan Ikan'],
                'nama_detail' => 'UPTD BBI Hortikultura dan PLK (PKK Agropark) Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura',
            ],


            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Badan Pengelolaan Keuangan dan Aset Daerah)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Badan Pendapatan Daerah)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Biro Umum)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Dinas Pariwisata dan Ekonomi Kreatif)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Pariwisata dan Ekonomi Kreatif)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Badan Pengelolaan Keuangan dan Aset Daerah)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Kehutanan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Sosial)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Tanaman Pangan, Ketahanan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Pemberdayaan Masyarakat Desa dan Transmigrasi)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Perindustrian dan Perdagangan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas UPTD BLK Way Abung (Dinas Tenaga Kerja)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas UPTD BLK Kalianda (Dinas Tenaga Kerja)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Rumah Dinas UPTD BLK Metro (Dinas Tenaga Kerja)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan UPTD Pelabuhan Perikanan (Dinas Kelautan dan Perikanan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Dinas Perhubungan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan dan Bangunan (Dinas Pemuda dan Olahraga)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPB Pekalongan (Rumah makan) (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan PKK Agropark (Kandang kuda) (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPTD BBI Tanaman Pangan dan Alsintan (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPTD BBI Tanaman Holtikultura dan PLB (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPTD BBI Tanaman Holtikultura dan PLB (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPTD Proteksi (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Lahan dan Bangunan (Dinas Perpustakaan dan Kearsipan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan UPTD BP2MB (Dinas Perkebunan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Tanah dan Bangunan'],
                'nama_detail' => 'Sewa Tanah/Lahan (Dinas Bina Marga dan Bina Konstruksi)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Bangunan'],
                'nama_detail' => 'UPTD Taman Budaya (Dinas Pendidikan dan Kebudayaan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Bangunan'],
                'nama_detail' => 'UPTD Taman Budaya (Dinas Pendidikan dan Kebudayaan)',
            ],
            [
                'rincian_id' => $rincian['Penyewaan Bangunan'],
                'nama_detail' => 'Sewa Gedung/ Aula/ Asrama/ Agro Park/ Lahan (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'UPTD Balai Pengawasan & S. Benih (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'UPTD LPPMHP (Dinas Kelautan dan Perikanan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'UPTD BP2MB (Dinas Perkebunan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'Laboratorium Kesehatan Hewan (Dinas Peternakan dan Kesehatan Hewan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'Laboratorium Kesehatan Hewan Sertifikasi (Dinas Peternakan dan Kesehatan Hewan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'Laboratorium (Dinas Bina Marga dan Bina Konstruksi)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'BLUD UPTD Laboratorium Kesehatan (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'UPTD BPSMB (Dinas Perindustrian dan Perdagangan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Laboratorium'],
                'nama_detail' => 'BLUD UPTD Laboratorium Lingkungan (Dinas Lingkungan Hidup)',
            ],

            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'Sewa Kamar Wisma Lampung (Badan Penghubung)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'UPTD Balai Pelatihan Kesehatan (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'UPTD Bandiklat dan UKM (Dinas Koperasi dan Usaha Kecil Menengah)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'Pemakaian Aula (Badan Pengelolaan Sumber Daya Manusia Daerah)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'Pemakaian Asrama (Badan Pengelolaan Sumber Daya Manusia Daerah)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'Ruang Kelas (Badan Pengelolaan Sumber Daya Manusia Daerah)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Ruangan'],
                'nama_detail' => 'Anjungan Lampung (Badan Penghubung)',
            ],

            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'UPTD Balai Industri & Kemasan (Dinas Perindustrian dan Perdagangan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'Sewa Alat-alat Berat (Dinas Bina Marrga dan Bina Konstruksi)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'Sewa Alat (Badan Pengelolaan Sumber Daya Manusia Daerah)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'Sewa Alat (Dinas Kesehatan)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'Pemakaian Alat (Dinas Tenaga Kerja)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'Pemakaian Alat Alsintan (Dinas Tanaman Pangan, Ketahanan Pangan dan Hortikultura)',
            ],
            [
                'rincian_id' => $rincian['Pemakaian Alat'],
                'nama_detail' => 'UPTD Balai Industri & Kemasan (Dinas Perindustrian dan Perdagangan)',
            ],

        ]);
    }
}