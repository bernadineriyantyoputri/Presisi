<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('target_retribusi', function (Blueprint $table) {
            $table->decimal('target_perubahan', 15, 0)->nullable()->after('target');
        });
    }

    public function down(): void
    {
        Schema::table('target_retribusi', function (Blueprint $table) {
            $table->dropColumn('target_perubahan');
        });
    }
};
