<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->string('nama_jenis_snapshot')->nullable();
            $table->string('nama_objek_snapshot')->nullable();
            $table->string('nama_rincian_snapshot')->nullable();
            $table->string('nama_detail_snapshot')->nullable();
        });
    }

    public function down()
    {
        Schema::table('laporan_detail', function (Blueprint $table) {
            $table->dropColumn([
                'nama_jenis_snapshot',
                'nama_objek_snapshot',
                'nama_rincian_snapshot',
                'nama_detail_snapshot',
            ]);
        });
    }
};
