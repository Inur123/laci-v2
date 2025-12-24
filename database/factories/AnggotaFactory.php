<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaFactory extends Factory
{
    protected $model = Anggota::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'nik' => fake()->numerify('################'),
            'nia' => fake()->numerify('##########'),
            'nama_lengkap' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date(),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_lengkap' => fake()->address(),
            'no_hp' => fake()->numerify('08##########'),
            'hobi' => fake()->words(3, true),
            'jabatan' => fake()->randomElement(['Anggota Biasa', 'Pengurus']),
            'no_rfid' => fake()->optional()->numerify('##########'),
        ];
    }
}
