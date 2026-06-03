<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal : exécute les seeders dans l'ordre des dépendances.
 * Ordre : référentiels (infractions, juridictions) → détenus et condamnations.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ReferentielSeeder::class,
            DetenuSeeder::class,
        ]);
    }
}
