<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CondamnationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_condamnation' => $this->id_condamnation,
            'date_debut_peine' => $this->date_debut_peine?->format('Y-m-d'),
            'duree_peine_mois' => $this->duree_peine_mois,
            'fin_peine' => $this->fin_peine?->format('Y-m-d'),
            'temps_ecoule_jours' => $this->tempsEcouleJours(),
            'temps_restant_jours' => $this->tempsRestantJours(),
            'infraction' => new InfractionResource($this->whenLoaded('infraction')),
            'juridiction' => new JuridictionResource($this->whenLoaded('juridiction')),
        ];
    }
}
