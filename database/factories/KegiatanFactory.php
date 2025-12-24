<?php

namespace Database\Factories;

use App\Models\Kegiatan;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KegiatanFactory extends Factory
{
    protected $model = Kegiatan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'judul' => fake()->sentence(3),
            'deskripsi' => fake()->optional()->paragraph(),
            'lokasi' => fake()->address(),
            'warna' => '#3788d8',
            'tanggal_mulai' => fake()->dateTime(),
            'tanggal_selesai' => fake()->optional()->dateTime(),
        ];
    }
}
