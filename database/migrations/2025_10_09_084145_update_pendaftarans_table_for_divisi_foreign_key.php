<?php

use App\Models\Divisi;
use App\Models\Pendaftaran;
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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('divisi_id')->nullable()->after('hp');
        });

        // Populate the new divisi_id column
        $pendaftarans = Pendaftaran::whereNotNull('divisi')->get();
        foreach ($pendaftarans as $pendaftaran) {
            $divisi = Divisi::where('nama_divisi', $pendaftaran->divisi)->first();
            if ($divisi) {
                $pendaftaran->divisi_id = $divisi->id;
                $pendaftaran->save();
            }
        }

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('set null');
            $table->dropColumn('divisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('divisi')->nullable()->after('hp');
        });

        // Populate the old divisi column
        $pendaftarans = Pendaftaran::whereNotNull('divisi_id')->get();
        foreach ($pendaftarans as $pendaftaran) {
            $divisi = Divisi::find($pendaftaran->divisi_id);
            if ($divisi) {
                $pendaftaran->divisi = $divisi->nama_divisi;
                $pendaftaran->save();
            }
        }

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['divisi_id']);
            $table->dropColumn('divisi_id');
        });
    }
};
