<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Sekretaris Cabang
        User::create([
            'name' => 'Sekretaris Cabang',
            'email' => 'sekretariscabang@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'sekretaris_cabang',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // User Sekretaris PAC
        User::create([
            'name' => 'Sekretaris PAC Magetan',
            'email' => 'sekretarispacmagetan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'sekretaris_pac',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
