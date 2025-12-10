<?php

namespace Database\Factories;

use App\Models\PengajuanSuratPac;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanSuratPacFactory extends Factory
{
    protected $model = PengajuanSuratPac::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id_pac' => Periode::factory(),
            'no_surat' => fake()->numerify('###/###/####'),
            'penerima' => fake()->name(),
            'tanggal' => fake()->date(),
            'keperluan' => fake()->sentence(5),
            'deskripsi' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'file' => 'test.pdf',
        ];
    }
}
