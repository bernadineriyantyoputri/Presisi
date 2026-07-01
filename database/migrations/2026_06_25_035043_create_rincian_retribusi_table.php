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
        Schema::create('rincian_retribusi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('objek_id')
                ->constrained('objek_retribusi')
                ->cascadeOnDelete();

            $table->string('nama_rincian');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_retribusi');
    }
};
