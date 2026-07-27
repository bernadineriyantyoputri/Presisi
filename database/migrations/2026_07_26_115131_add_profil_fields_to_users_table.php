<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('foto')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('lokasi_kantor')->nullable();
            $table->string('id_pegawai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jabatan', 'no_telepon', 'foto',
                'unit_kerja', 'lokasi_kantor', 'id_pegawai',
            ]);
        });
    }
};