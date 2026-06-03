<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;


class PingController extends Controller
{
    #[OA\Get(
        path: '/ping',
        summary: 'Vérifier que l\'API est disponible',
        description: 'Endpoint de test pour Swagger — confirme que le serveur répond.',
        tags: ['Santé'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Serveur opérationnel',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'up'),
                        new OA\Property(property: 'message', type: 'string', example: 'API Gestion Pénitentiaire opérationnelle'),
                    ]
                )
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'up',
            'message' => 'API Gestion Pénitentiaire opérationnelle',
        ]);
    }
}
