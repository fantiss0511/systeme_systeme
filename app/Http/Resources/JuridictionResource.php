<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JuridictionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_juridiction' => $this->id_juridiction,
            'nom' => $this->nom,
            'ville' => $this->ville,
        ];
    }
}
