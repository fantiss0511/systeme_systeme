<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCondamnationRequest;
use App\Http\Requests\UpdateCondamnationRequest;
use App\Http\Resources\CondamnationResource;
use App\Models\Condamnation;
use App\Models\Detenu;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CondamnationController extends Controller
{
    #[OA\Get(
        path: '/detenus/{detenu}/condamnations',
        summary: 'Lister les condamnations d\'un détenu',
        tags: ['Condamnations'],
        parameters: [
            new OA\Parameter(name: 'detenu', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Liste des condamnations'),
            new OA\Response(response: 404, description: 'Détenu introuvable'),
        ]
    )]
    public function index(Detenu $detenu)
    {
        $condamnations = $detenu->condamnations()
            ->with(['infraction', 'juridiction'])
            ->orderByDesc('date_debut_peine')
            ->get();

        return CondamnationResource::collection($condamnations);
    }

    #[OA\Post(
        path: '/detenus/{detenu}/condamnations',
        summary: 'Enregistrer une condamnation',
        description: 'La date de fin de peine est calculée automatiquement (date_debut + duree_peine_mois).',
        tags: ['Condamnations'],
        parameters: [
            new OA\Parameter(name: 'detenu', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CondamnationInput')
        ),
        responses: [
            new OA\Response(response: 201, description: 'Condamnation créée'),
            new OA\Response(response: 404, description: 'Détenu introuvable'),
            new OA\Response(response: 422, description: 'Erreur de validation'),
        ]
    )]
    public function store(StoreCondamnationRequest $request, Detenu $detenu): JsonResponse
    {
        $condamnation = $detenu->condamnations()->create($request->validated());
        $condamnation->load(['infraction', 'juridiction']);

        return (new CondamnationResource($condamnation))
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(
        path: '/condamnations/{condamnation}',
        summary: 'Consulter une condamnation',
        tags: ['Condamnations'],
        parameters: [
            new OA\Parameter(name: 'condamnation', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Détail de la condamnation'),
            new OA\Response(response: 404, description: 'Condamnation introuvable'),
        ]
    )]
    public function show(Condamnation $condamnation): CondamnationResource
    {
        $condamnation->load(['infraction', 'juridiction']);

        return new CondamnationResource($condamnation);
    } // <-- CORRECTION : L'accolade manquante était ici

    #[OA\Put(
        path: '/condamnations/{condamnation}',
        summary: 'Modifier une condamnation',
        tags: ['Condamnations'],
        parameters: [
            new OA\Parameter(name: 'condamnation', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/CondamnationInput')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Condamnation mise à jour'),
            new OA\Response(response: 404, description: 'Condamnation introuvable'),
            new OA\Response(response: 422, description: 'Erreur de validation'),
        ]
    )]
    public function update(UpdateCondamnationRequest $request, Condamnation $condamnation): CondamnationResource
    {
        $condamnation->update($request->validated());
        $condamnation->load(['infraction', 'juridiction']);

        return new CondamnationResource($condamnation);
    }

    #[OA\Delete(
        path: '/condamnations/{condamnation}',
        summary: 'Supprimer une condamnation',
        tags: ['Condamnations'],
        parameters: [
            new OA\Parameter(name: 'condamnation', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Condamnation supprimée', content: new OA\JsonContent(ref: '#/components/schemas/MessageResponse')),
            new OA\Response(response: 404, description: 'Condamnation introuvable'),
        ]
    )]
    public function destroy(Condamnation $condamnation): JsonResponse
    {
        $condamnation->delete();

        return response()->json(['message' => 'Condamnation supprimée avec succès.']);
    }
}