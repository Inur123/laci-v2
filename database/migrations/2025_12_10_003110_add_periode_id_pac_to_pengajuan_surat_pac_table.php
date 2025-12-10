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
        Schema::table('pengajuan_surat_pac', function (Blueprint $table) {
            $table->uuid('periode_id_pac')->nullable()->after('user_id');
            $table->foreign('periode_id_pac')->references('id')->on('periodes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_surat_pac', function (Blueprint $table) {
            $table->dropForeign(['periode_id_pac']);
            $table->dropColumn('periode_id_pac');
        });
    }
};
