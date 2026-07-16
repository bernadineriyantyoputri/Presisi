<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom sementara
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->string('status_verifikasi_new')->default('Pending')->after('status_verifikasi');
        });

        // 2. Migrasikan data lama (boolean) ke nilai string baru
        DB::table('perangkat_daerah')->where('status_verifikasi', true)
            ->update(['status_verifikasi_new' => 'Terverifikasi']);

        DB::table('perangkat_daerah')->where('status_verifikasi', false)
            ->update(['status_verifikasi_new' => 'Pending']);

        // 3. Hapus kolom lama, rename kolom baru
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });

        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->renameColumn('status_verifikasi_new', 'status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->boolean('status_verifikasi')->default(false)->change();
        });
    }
};