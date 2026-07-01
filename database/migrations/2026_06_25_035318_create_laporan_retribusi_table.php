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
        Schema::create('laporan_retribusi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('perangkat_daerah_id')
                ->constrained('perangkat_daerah')
                ->cascadeOnDelete();

            $table->integer('bulan');
            $table->integer('tahun');

            $table->date('tanggal_submit')
                ->nullable();

            $table->enum('status', [
                'draft',
                'submit'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_retribusi');
    }
};
