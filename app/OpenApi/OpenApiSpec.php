<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;


 //Configuration globale de la documentation Swagger/OpenAPI.
#[OA\Info(
    title: 'Gestion Pénitentiaire API',
    version: '1.0.0',
    description: 'API REST pour le recensement des détenus, le suivi des condamnations et les statistiques pénitentiaires.'
)]
#[OA\Server(url: 'http://localhost:8000/api', description: 'Serveur local')]
#[OA\Tag(name: 'Santé', description: 'Vérification du serveur')]
#[OA\Tag(name: 'Détenus', description: 'Enregistrement, recherche et fiches de synthèse')]
#[OA\Tag(name: 'Listes', description: 'Listes des présents, sorties prévues et décès')]
#[OA\Tag(name: 'Condamnations', description: 'Condamnations judiciaires')]
#[OA\Tag(name: 'Statistiques', description: 'Répartitions par infraction et par âge')]
#[OA\Tag(name: 'Référentiels', description: 'Infractions et juridictions')]
// Schéma JSON pour la création/modification d'un détenu
#[OA\Schema(
    schema: 'DetenuInput',
    required: ['matricule_ou_nina', 'nom', 'prenom', 'date_naissance', 'sexe'],
    properties: [
        new OA\Property(property: 'matricule_ou_nina', type: 'string', example: 'NINA-2026001'),
        new OA\Property(property: 'nom', type: 'string', example: 'Diallo'),
        new OA\Property(property: 'prenom', type: 'string', example: 'Amadou'),
        new OA\Property(property: 'date_naissance', type: 'string', format: 'date', example: '1990-05-15'),
        new OA\Property(property: 'sexe', type: 'string', enum: ['M', 'F'], example: 'M'),
        new OA\Property(property: 'photo', type: 'string', nullable: true, example: 'photos/detenu.jpg'),
        new OA\Property(property: 'statut', type: 'string', enum: ['present', 'libere', 'decede'], example: 'present'),
    ]
)]
// Schéma JSON pour la création/modification d'une condamnation
#[OA\Schema(
    schema: 'CondamnationInput',
    required: ['id_infraction', 'id_juridiction', 'date_debut_peine', 'duree_peine_mois'],
    properties: [
        new OA\Property(property: 'id_infraction', type: 'integer', example: 1),
        new OA\Property(property: 'id_juridiction', type: 'integer', example: 1),
        new OA\Property(property: 'date_debut_peine', type: 'string', format: 'date', example: '2024-01-10'),
        new OA\Property(property: 'duree_peine_mois', type: 'integer', example: 36),
    ]
)]
// Schéma JSON pour les réponses de confirmation (suppression, etc.)
#[OA\Schema(
    schema: 'MessageResponse',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'Opération réussie.'),
    ]
)]
class OpenApiSpec
{
}
