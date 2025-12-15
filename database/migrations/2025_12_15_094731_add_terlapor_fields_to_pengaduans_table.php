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
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('nama_terlapor')->nullable()->after('status');
            $table->string('nim_terlapor')->nullable()->after('nama_terlapor');
            $table->string('status_terlapor')->nullable()->after('nim_terlapor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['nama_terlapor', 'nim_terlapor', 'status_terlapor']);
        });
    }
};
