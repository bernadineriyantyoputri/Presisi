<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporan_retribusi')
                ->cascadeOnDelete();

            $table->foreignId('detail_retribusi_id')
                ->constrained('detail_retribusi')
                ->cascadeOnDelete();

            $table->decimal('realisasi_bulan_lalu',18,2)
                ->default(0);

            $table->decimal('realisasi_bulan_ini',18,2)
                ->default(0);

            $table->decimal('total_realisasi',18,2)
                ->default(0);

            $table->decimal('persentase',10,2)
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_detail');
    }
};
