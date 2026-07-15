<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_retribusi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('detail_id')
                ->nullable()
                ->constrained('detail_retribusi')
                ->cascadeOnDelete();

            $table->foreignId('rincian_id')
                ->nullable()
                ->constrained('rincian_retribusi')
                ->cascadeOnDelete();

            $table->year('tahun');

            $table->decimal('target_nominal',18,2)->default(0);

            $table->timestamps();

            $table->unique(
                ['detail_id','tahun'],
                'uniq_target_detail'
            );

            $table->unique(
                ['rincian_id','tahun'],
                'uniq_target_rincian'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_retribusi');
    }
};