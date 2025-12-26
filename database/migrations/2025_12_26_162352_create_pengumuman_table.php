<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // pengirim (sekretaris_cabang)
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            // periode target (ambil dari periode_aktif_id pengirim)
            $table->foreignUuid('periode_id')->constrained('periodes')->onDelete('cascade');

            $table->text('judul');
            $table->longText('isi');

            $table->unsignedInteger('sent_to_count')->default(0);
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
