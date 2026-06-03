<?php

namespace App\Http\Controllers;

use App\Models\Detenu;
use App\Models\Infraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;


 
class StatistiqueController extends Controller
{
    
    #[OA\Get(
        path: '/statistiques/par-infraction',
        summary: 'Répartition des détenus par type d\'infraction',
        tags: ['Statistiques'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Statistiques par infraction (détenus présents uniquement)',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'repartition_par_infraction', type: 'array', items: new OA\Items(type: 'object')),
                        new OA\Property(property: 'total_detenus_presents', type: 'integer', example: 42),
                    ]
                )
            ),
        ]
    )]
    public function parInfraction(): JsonResponse
    {
        $stats = Infraction::query()
            ->leftJoin('condamnations', 'infractions.id_infraction', '=', 'condamnations.id_infraction')
            ->leftJoin('detenus', function ($join) {
                // compte que les détenus encore incarcérés
                $join->on('condamnations.matricule_detenu', '=', 'detenus.matricule_ou_nina')
                    ->where('detenus.statut', '=', 'present');
            })
            ->select(
                'infractions.id_infraction',
                'infractions.nature',
                'infractions.type_infraction',
                DB::raw('COUNT(DISTINCT detenus.matricule_ou_nina) as nombre_detenus')
            )
            ->groupBy('infractions.id_infraction', 'infractions.nature', 'infractions.type_infraction')
            ->orderByDesc('nombre_detenus')
            ->get();

        return response()->json([
            'repartition_par_infraction' => $stats,
            'total_detenus_presents' => Detenu::present()->count(),
        ]);
    }

   
    #[OA\Get(
        path: '/statistiques/par-age',
        summary: 'Répartition des détenus par tranche d\'âge',
        tags: ['Statistiques'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Statistiques par tranche d\'âge (détenus présents uniquement)',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'repartition_par_age', type: 'array', items: new OA\Items(type: 'object')),
                        new OA\Property(property: 'total_detenus_presents', type: 'integer', example: 42),
                    ]
                )
            ),
        ]
    )]
    public function parAge(): JsonResponse
    {
        $detenus = Detenu::present()->get(['date_naissance']);

        // Initialisation du compteur par tranche d'âge
        $tranches = [
            '18-25 ans' => 0,
            '26-35 ans' => 0,
            '36-45 ans' => 0,
            '46-55 ans' => 0,
            '56 ans et plus' => 0,
        ];

        foreach ($detenus as $detenu) {
            $age = $detenu->date_naissance->age;

            if ($age <= 25) {
                $tranches['18-25 ans']++;
            } elseif ($age <= 35) {
                $tranches['26-35 ans']++;
            } elseif ($age <= 45) {
                $tranches['36-45 ans']++;
            } elseif ($age <= 55) {
                $tranches['46-55 ans']++;
            } else {
                $tranches['56 ans et plus']++;
            }
        }

        //  réponse JSON
        $resultat = collect($tranches)->map(fn ($count, $tranche) => [
            'tranche' => $tranche,
            'nombre_detenus' => $count,
        ])->values();

        return response()->json([
            'repartition_par_age' => $resultat,
            'total_detenus_presents' => $detenus->count(),
        ]);
    }
}
