<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisRetribusi;

class JenisRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    JenisRetribusi::insert([
        ['nama_jenis' => 'Jasa Umum'],
        ['nama_jenis' => 'Jasa Usaha'],
        ['nama_jenis' => 'Jasa Perizinan Tertentu'],
    ]);
}
}
