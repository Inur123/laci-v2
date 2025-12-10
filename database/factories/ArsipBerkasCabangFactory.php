<?php

namespace Database\Factories;

use App\Models\ArsipBerkasCabang;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArsipBerkasCabangFactory extends Factory
{
    protected $model = ArsipBerkasCabang::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'nama' => fake()->sentence(3),
            'tanggal' => fake()->date(),
            'catatan' => fake()->optional()->paragraph(),
            'file_path' => 'test.pdf',
        ];
    }
}
