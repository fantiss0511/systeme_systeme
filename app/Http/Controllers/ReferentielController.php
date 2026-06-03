<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfractionResource;
use App\Http\Resources\JuridictionResource;
use App\Models\Infraction;
use App\Models\Juridiction;
use OpenApi\Attributes as OA;


class ReferentielController extends Controller
{
    #[OA\Get(
        path: '/infractions',
        summary: 'Lister les infractions',
        description: 'Référentiel des natures d\'infraction (utile avant d\'enregistrer une condamnation).',
        tags: ['Référentiels'],
        responses: [
            new OA\Response(response: 200, description: 'Liste des infractions'),
        ]
    )]
    public function infractions()
    {
        return InfractionResource::collection(Infraction::orderBy('nature')->get());
    }
    #[OA\Get(
        path: '/juridictions',
        summary: 'Lister les juridictions',
        description: 'Référentiel des juridictions de condamnation.',
        tags: ['Référentiels'],
        responses: [
            new OA\Response(response: 200, description: 'Liste des juridictions'),
        ]
    )]
    public function juridictions()
    {
        return JuridictionResource::collection(Juridiction::orderBy('nom')->get());
    }
}
