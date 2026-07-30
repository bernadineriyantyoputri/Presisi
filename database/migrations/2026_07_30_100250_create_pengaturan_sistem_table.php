<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sistem')->default('PRESISI');
            $table->string('tahun_anggaran_aktif')->nullable();
            $table->text('teks_footer')->nullable();
            $table->string('logo_sistem')->nullable();
            $table->string('logo_bapenda')->nullable();

            // Notifikasi
            $table->boolean('notif_laporan_masuk')->default(true);
            $table->boolean('notif_target_belum_tercapai')->default(true);
            $table->boolean('notif_perubahan_data')->default(true);
            $table->boolean('notif_pengingat_laporan')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_sistem');
    }
};