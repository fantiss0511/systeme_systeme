<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Utilise les condamnations déjà chargées pour éviter une requête SQL supplémentaire
        $condamnationPrincipale = $this->relationLoaded('condamnations')
            ? $this->condamnations->sortByDesc('fin_peine')->first()
            : $this->condamnationPrincipale();

        return [
            'matricule_ou_nina' => $this->matricule_ou_nina,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->date_naissance?->format('Y-m-d'),
            'age' => $this->date_naissance?->age,
            'sexe' => $this->sexe,
            'photo' => $this->photo,
            'statut' => $this->statut,
            'condamnations' => CondamnationResource::collection($this->whenLoaded('condamnations')),
            // code pour la fiche de synthèse
            'synthese' => $condamnationPrincipale ? [
                'date_debut_peine' => $condamnationPrincipale->date_debut_peine?->format('Y-m-d'),
                'date_sortie_prevue' => $condamnationPrincipale->fin_peine?->format('Y-m-d'),
                'duree_peine_mois' => $condamnationPrincipale->duree_peine_mois,
                'temps_ecoule_jours' => $condamnationPrincipale->tempsEcouleJours(),
                'temps_restant_jours' => $condamnationPrincipale->tempsRestantJours(),
            ] : null,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}




