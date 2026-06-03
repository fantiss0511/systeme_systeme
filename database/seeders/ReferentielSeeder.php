<?php

namespace Database\Seeders;

use App\Models\Infraction;
use App\Models\Juridiction;
use Illuminate\Database\Seeder;

/**
 * Insère les données de référence : infractions et juridictions.
 * Nécessaire avant d'enregistrer des condamnations (clés étrangères).
 */
class ReferentielSeeder extends Seeder
{
    public function run(): void
    {
        $infractions = [
            ['nature' => 'Vol simple', 'type_infraction' => 'Atteinte aux biens'],
            ['nature' => 'Vol aggravé', 'type_infraction' => 'Atteinte aux biens'],
            ['nature' => 'Escroquerie', 'type_infraction' => 'Atteinte aux biens'],
            ['nature' => 'Homicide involontaire', 'type_infraction' => 'Atteinte aux personnes'],
            ['nature' => 'Coups et blessures', 'type_infraction' => 'Atteinte aux personnes'],
            ['nature' => 'Trafic de stupéfiants', 'type_infraction' => 'Infractions liées aux stupéfiants'],
            ['nature' => 'Détention de stupéfiants', 'type_infraction' => 'Infractions liées aux stupéfiants'],
            ['nature' => 'Fraude fiscale', 'type_infraction' => 'Infractions économiques'],
        ];

        // firstOrCreate évite les doublons si le seeder est relancé
        foreach ($infractions as $infraction) {
            Infraction::firstOrCreate(
                ['nature' => $infraction['nature']],
                $infraction
            );
        }

        $juridictions = [
            ['nom' => 'Tribunal de Grande Instance de Bamako', 'ville' => 'Bamako'],
            ['nom' => 'Tribunal de Grande Instance de Kayes', 'ville' => 'Kayes'],
            ['nom' => 'Tribunal de Grande Instance de Sikasso', 'ville' => 'Sikasso'],
            ['nom' => 'Tribunal de Grande Instance de Ségou', 'ville' => 'Ségou'],
            ['nom' => 'Cour d\'Appel de Bamako', 'ville' => 'Bamako'],
        ];

        foreach ($juridictions as $juridiction) {
            Juridiction::firstOrCreate(
                ['nom' => $juridiction['nom']],
                $juridiction
            );
        }
    }
}
