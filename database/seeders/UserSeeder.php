<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Crée un compte administrateur par défaut pour tester la connexion.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@penitentiaire.ml'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
