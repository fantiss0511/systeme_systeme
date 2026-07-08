<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetenuRequest;
use App\Http\Requests\UpdateDetenuRequest;
use App\Http\Resources\DetenuResource;
use App\Models\Detenu;
use App\Models\Infraction; 
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class DetenuController extends Controller
{
    #[OA\Get(
        path: '/detenus',
        summary: 'Lister / rechercher les détenus',
        description: 'Recherche multicritère par nom, numéro Nina, date d\'entrée ou statut.',
        tags: ['Détenus'],
        parameters: [
            new OA\Parameter(name: 'nom', in: 'query', required: false, schema: new OA\Schema(type: 'string'), example: 'Diallo'),
            new OA\Parameter(name: 'nina', in: 'query', required: false, schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
            new OA\Parameter(name: 'date_entree', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date'), example: '2024-01-10'),
            new OA\Parameter(name: 'statut', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['present', 'libere', 'decede'])),
            new OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Liste paginée des détenus'),
        ]
    )]
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Detenu::query()
            ->with(['condamnations.infraction', 'condamnations.juridiction'])
            ->search(
                $request->query('nom'),
                $request->query('nina'),
                $request->query('date_entree')
            );

        if ($statut = $request->query('statut')) {
            $query->where('statut', $statut);
        }

        $detenus = $query->orderBy('nom')->orderBy('prenom')->paginate(15);

        return DetenuResource::collection($detenus);
    }

    #[OA\Post(
        path: '/detenus',
        summary: 'Enregistrer un détenu',
        tags: ['Détenus'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/DetenuInput')
        ),
        responses: [
            new OA\Response(response: 201, description: 'Détenu créé'),
            new OA\Response(response: 422, description: 'Erreur de validation'),
        ]
    )]
    public function store(StoreDetenuRequest $request): JsonResponse
    {
        $detenu = Detenu::create($request->validated());

        return (new DetenuResource($detenu))
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(
        path: '/detenus/{detenu}',
        summary: 'Fiche de synthèse d\'un détenu',
        description: 'Affiche les informations personnelles, condamnations, temps écoulé et temps restant.',
        tags: ['Détenus'],
        parameters: [
            new OA\Parameter(name: 'detenu', in: 'path', required: true, description: 'ID ou NINA ', schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Fiche détenu'),
            new OA\Response(response: 404, description: 'Détenu introuvable'),
        ]
    )]
    public function show(Detenu $detenu): DetenuResource
    {
        $detenu->load(['condamnations.infraction', 'condamnations.juridiction']);

        return new DetenuResource($detenu);
    }

    #[OA\Put(
        path: '/detenus/{detenu}',
        summary: 'Modifier un détenu',
        tags: ['Détenus'],
        parameters: [
            new OA\Parameter(name: 'detenu', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/DetenuInput')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Détenu mis à jour'),
            new OA\Response(response: 404, description: 'Détenu introuvable'),
        ]
    )]
    public function update(UpdateDetenuRequest $request, Detenu $detenu): DetenuResource
    {
        $detenu->update($request->validated());
        
        $detenu->load(['condamnations.infraction', 'condamnations.juridiction']);

        return new DetenuResource($detenu);
    }

    #[OA\Delete(
        path: '/detenus/{detenu}',
        summary: 'Supprimer un détenu',
        tags: ['Détenus'],
        parameters: [
            new OA\Parameter(name: 'detenu', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'NINA-2026001'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Détenu supprimé'),
            new OA\Response(response: 404, description: 'Détenu introuvable'),
        ]
    )]
    public function destroy(Detenu $detenu): JsonResponse
    {
        $detenu->delete();

        return response()->json(['message' => 'Détenu supprimé avec succès.']);
    }

    #[OA\Get(
        path: '/detenus/listes/presents',
        summary: 'Liste des détenus présents',
        tags: ['Listes'],
        responses: [
            new OA\Response(response: 200, description: 'Liste des détenus avec statut present'),
        ]
    )]
    public function presents(): AnonymousResourceCollection
    {
        $detenus = Detenu::where('statut', 'present')
            ->with(['condamnations.infraction', 'condamnations.juridiction'])
            ->orderBy('nom')
            ->paginate(15);

        return DetenuResource::collection($detenus);
    }

    #[OA\Get(
        path: '/detenus/listes/sorties-prevues',
        summary: 'Sorties prévues pour un mois donné',
        tags: ['Listes'],
        parameters: [
            new OA\Parameter(name: 'mois', in: 'query', required: false, schema: new OA\Schema(type: 'integer', example: 5)),
            new OA\Parameter(name: 'annee', in: 'query', required: false, schema: new OA\Schema(type: 'integer', example: 2026)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Détenus dont la fin de peine est prévue ce mois-ci'),
        ]
    )]
    public function sortiesPrevues(Request $request): AnonymousResourceCollection
    {
        $mois = (int) $request->query('mois', now()->month);
        $annee = (int) $request->query('annee', now()->year);

        $detenus = Detenu::sortiesPrevuesMois($mois, $annee)
            ->with(['condamnations.infraction', 'condamnations.juridiction'])
            ->orderBy('nom')
            ->paginate(15);

        return DetenuResource::collection($detenus);
    }

    #[OA\Get(
        path: '/detenus/listes/deces',
        summary: 'Liste des décès',
        tags: ['Listes'],
        responses: [
            new OA\Response(response: 200, description: 'Liste des détenus avec statut decede'),
        ]
    )]
    public function deces(): AnonymousResourceCollection
    {
        $detenus = Detenu::where('statut', 'decede')
            ->with(['condamnations.infraction', 'condamnations.juridiction'])
            ->orderBy('nom')
            ->paginate(15);

        return DetenuResource::collection($detenus);
    }

    // Récupère la clé de route pour le modèle.
     
    public function getRouteKeyName()
    {
        return 'nina'; 
    }

    
     //Formulaire de création d'un détenu.
     // Récupère les infractions triées pour la liste déroulante.
     
    public function create()
    {
        $infractions = Infraction::orderBy('nature')->get();
        
        
        return view('admin.detenu.create', compact('infractions'));
    }
}