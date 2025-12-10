<?php

namespace Database\Factories;

use App\Models\Surat;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratFactory extends Factory
{
    protected $model = Surat::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'no_surat' => fake()->numerify('###/IPNU/'.date('Y')),
            'perihal' => fake()->sentence(5),
            'jenis_surat' => fake()->randomElement(['masuk', 'keluar']),
            'tanggal' => fake()->date(),
            'pengirim_penerima' => fake()->company(),
            'deskripsi' => fake()->optional()->paragraph(),
            'file' => 'surats/dummy.pdf',
        ];
    }

    public function masuk()
    {
        return $this->state(function (array $attributes) {
            return [
                'jenis_surat' => 'masuk',
            ];
        });
    }

    public function keluar()
    {
        return $this->state(function (array $attributes) {
            return [
                'jenis_surat' => 'keluar',
            ];
        });
    }
}
