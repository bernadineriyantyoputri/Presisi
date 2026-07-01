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
        Schema::create('detail_retribusi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rincian_id')
                ->constrained('rincian_retribusi')
                ->cascadeOnDelete();

            $table->string('nama_detail');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_retribusi');
    }
};
