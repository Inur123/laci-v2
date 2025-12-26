<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman_recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // FK ke tabel pengumuman (UUID)
            $table->foreignUuid('pengumuman_id')
                ->constrained('pengumuman')
                ->cascadeOnDelete();

            // FK ke users (UUID) - optional
            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('email');
            $table->string('status', 20); // sent | failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();

            $table->index(['pengumuman_id', 'status']);
            $table->index(['pengumuman_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman_recipients');
    }
};
