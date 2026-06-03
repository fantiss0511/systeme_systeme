<?php

namespace Database\Seeders;

use App\Models\Condamnation;
use App\Models\Detenu;
use App\Models\Infraction;
use App\Models\Juridiction;
use Illuminate\Database\Seeder;

/**
 * Insère des détenus et condamnations de démonstration pour les tests.
 * Dépend du ReferentielSeeder (infractions et juridictions doivent exister).
 */
class DetenuSeeder extends Seeder
{
    public function run(): void
    {
        $infraction = Infraction::first();
        $juridiction = Juridiction::first();

        // Abandon si les référentiels ne sont pas encore chargés
        if (! $infraction || ! $juridiction) {
            return;
        }

        // Premier détenu de test avec condamnation de 36 mois
        $detenu = Detenu::firstOrCreate(
            ['matricule_ou_nina' => 'NINA-2026001'],
            [
                'nom' => 'Diallo',
                'prenom' => 'Amadou',
                'date_naissance' => '1990-05-15',
                'sexe' => 'M',
                'statut' => 'present',
            ]
        );

        Condamnation::firstOrCreate(
            [
                'matricule_detenu' => $detenu->matricule_ou_nina,
                'date_debut_peine' => '2024-01-10',
            ],
            [
                'id_infraction' => $infraction->id_infraction,
                'id_juridiction' => $juridiction->id_juridiction,
                'duree_peine_mois' => 36,
            ]
        );

        // Second détenu de test avec condamnation de 24 mois
        Detenu::firstOrCreate(
            ['matricule_ou_nina' => 'NINA-2026002'],
            [
                'nom' => 'Traoré',
                'prenom' => 'Fatoumata',
                'date_naissance' => '1985-11-22',
                'sexe' => 'F',
                'statut' => 'present',
            ]
        )->condamnations()->firstOrCreate(
            ['date_debut_peine' => '2023-06-01'],
            [
                'id_infraction' => $infraction->id_infraction,
                'id_juridiction' => $juridiction->id_juridiction,
                'duree_peine_mois' => 24,
            ]
        );
    }
}
