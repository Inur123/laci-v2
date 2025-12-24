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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->longText('nik')->nullable();
            $table->longText('nia')->nullable();
            $table->longText('email')->nullable();
            $table->longText('foto')->nullable();
            $table->longText('nama_lengkap');
            $table->longText('tempat_lahir')->nullable();
            $table->longText('tanggal_lahir')->nullable();
            $table->longText('jenis_kelamin')->nullable();
            $table->longText('alamat_lengkap')->nullable();
            $table->longText('no_hp')->nullable();
            $table->longText('hobi')->nullable();
            $table->text('jabatan')->nullable();
            $table->longText('no_rfid')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
