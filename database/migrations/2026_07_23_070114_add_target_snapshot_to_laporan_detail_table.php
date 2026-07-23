<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->decimal('target_snapshot', 18, 2)
                  ->default(0)
                  ->after('total_realisasi');

            $table->enum('target_aktif_snapshot', ['murni', 'perubahan'])
                  ->nullable()
                  ->after('target_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->dropColumn([
                'target_snapshot',
                'target_aktif_snapshot'
            ]);
        });
    }
};