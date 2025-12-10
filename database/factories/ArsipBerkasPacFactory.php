<?php

namespace Database\Factories;

use App\Models\ArsipBerkasPac;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArsipBerkasPacFactory extends Factory
{
    protected $model = ArsipBerkasPac::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'nama' => fake()->sentence(3),
            'tanggal_mulai' => fake()->date(),
            'tanggal_berakhir' => fake()->date(),
            'catatan' => fake()->optional()->paragraph(),
            'file_path' => 'test.pdf',
        ];
    }
}
