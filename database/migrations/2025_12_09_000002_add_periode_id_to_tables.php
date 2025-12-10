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
        // Tambah kolom periode_id ke tabel surat
        Schema::table('surat', function (Blueprint $table) {
            $table->uuid('periode_id')->nullable()->after('user_id');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('set null');
        });

        // Tambah kolom periode_id ke tabel pengajuan_surat_pac
        Schema::table('pengajuan_surat_pac', function (Blueprint $table) {
            $table->uuid('periode_id')->nullable()->after('user_id');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('set null');
        });

        // Tambah kolom periode_id ke tabel kegiatan
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->uuid('periode_id')->nullable()->after('user_id');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
        });

        Schema::table('pengajuan_surat_pac', function (Blueprint $table) {
            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
        });

        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
        });
    }
};
