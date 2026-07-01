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
        Schema::create('perangkat_daerah', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_perangkat');
            $table->string('kepala_perangkat');
            $table->string('pangkat_golongan');
            $table->string('nip');

            $table->string('bendahara_penerimaan');
            $table->string('no_hp');
            $table->string('email');

            $table->boolean('status_verifikasi')
                ->default(false);

            $table->timestamp('tanggal_verifikasi')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_daerah');
    }
};
