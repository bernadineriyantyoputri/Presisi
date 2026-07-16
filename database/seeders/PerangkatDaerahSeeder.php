<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PerangkatDaerahSeeder extends Seeder
{
    public function run(): void
    {
        $perangkatDaerah = [
            'Badan Pendapatan Daerah',
            'Badan Pengelolaan Keuangan dan Aset Daerah',
            'Badan Pengembangan Sumber Daya Manusia',
            'Badan Penghubung Perwakilan',
            'Biro Umum Sekretariat Daerah',
            'Dinas Bina Marga dan Bina Konstruksi',
            'Dinas Kehutanan',
            'Dinas Kelautan dan Perikanan',
            'Dinas Kesehatan',
            'Dinas Ketahanan Pangan, Tanaman Pangan dan Hortikultura',
            'Dinas Koperasi dan Usaha Kecil Menengah',
            'Dinas Pariwisata dan Ekonomi Kreatif',
            'Dinas Pemberdayaan Masyarakat Desa dan Transmigrasi',
            'Dinas Pemuda dan Olahraga',
            'Dinas Pendidikan dan Kebudayaan',
            'Dinas Perhubungan',
            'Dinas Perindustrian dan Perdagangan',
            'Dinas Perkebunan',
            'Dinas Perpustakaan dan Kearsipan',
            'Dinas Peternakan dan Kesehatan Hewan',
            'Dinas Sosial',
            'Dinas Tenaga Kerja',
            'BLUD Rumah Sakit Bandar Negara Husada',
            'BLUD Rumah Sakit Jiwa',
            'BLUD Rumah Sakit Umum Daerah Abdoel Muluk',
            'BLUD Dinas Pendidikan dan Kebudayaan',
            'BLUD Dinas Lingkungan Hidup',
            'BLUD Dinas Kesehatan',
        ];

        foreach ($perangkatDaerah as $index => $nama) {

            // Email dibuat otomatis
            $email = 'pd' . ($index + 1) . '@presisi.go.id';

            $user = User::firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'name' => $nama,
                    'password' => Hash::make('password123'),
                    'role' => 'admin_perangkat',
                ]
            );

            PerangkatDaerah::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'nama_perangkat' => $nama,
                    'kepala_perangkat' => '-',
                    'pangkat_golongan' => '-',
                    'nip' => '-',
                    'bendahara_penerimaan' => '-',
                    'no_hp' => '-',
                    'email' => $email,
                    'status_verifikasi' => 'true',
                ]
            );
        }
    }
}