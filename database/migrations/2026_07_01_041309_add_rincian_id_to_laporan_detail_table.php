<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_detail', 'rincian_id')) {
                $table->foreignId('rincian_id')
                    ->nullable()
                    ->after('laporan_id')
                    ->constrained('rincian_retribusi')
                    ->nullOnDelete();
            }
        });

        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->foreignId('detail_retribusi_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_detail', 'rincian_id')) {
                $table->dropConstrainedForeignId('rincian_id');
            }
        });

        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->foreignId('detail_retribusi_id')->nullable(false)->change();
        });
    }
};