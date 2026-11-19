<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // First personalized user.
        User::create([
            'name' => 'Red Isaac Genilla',
            'email' => 'genilla@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        // Second personalized user.
        User::create([
            'name' => 'Tita Genilla',
            'email' => 'tita.genilla@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        // Create ten additional users.
        User::factory()->count(10)->create();
    }
}
