<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'foto']);
        });

        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->renameColumn('no_hp', 'no_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->string('foto')->nullable();
        });

        // Kembalikan nama kolom no_telepon → no_hp di perangkat_daerah
        Schema::table('perangkat_daerah', function (Blueprint $table) {
            $table->renameColumn('no_telepon', 'no_hp');
        });
    }
};
