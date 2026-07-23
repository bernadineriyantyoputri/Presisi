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
    Schema::table('target_retribusi', function (Blueprint $table) {
        $table->enum('target_aktif', ['murni', 'perubahan'])
              ->default('murni')
              ->after('target_perubahan');
    });
}

public function down(): void
{
    Schema::table('target_retribusi', function (Blueprint $table) {
        $table->dropColumn('target_aktif');
    });
}
};
