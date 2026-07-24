<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Siapa yang melakukan aksi (opsional, boleh null misal aksi sistem)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Dipakai untuk kebutuhan filter/analitik nanti, mis: 'akun_baru', 'laporan_verifikasi'
            $table->string('type')->nullable();

            // Ditampilkan di kolom "Aktivitas", mis: "Akun baru didaftarkan"
            $table->string('aktivitas');

            // Ditampilkan di kolom "Detail", mis: "UPTD Puskesmas Kota Baru"
            $table->string('detail')->nullable();

            // Nama icon bootstrap-icons, mis: 'bi-check-circle-fill'
            $table->string('icon')->default('bi-info-circle-fill');

            // Warna badge/icon: blue, green, purple, orange, teal
            $table->string('icon_color')->default('blue');

            // 'Selesai' atau 'Proses'
            $table->string('status')->default('Selesai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};