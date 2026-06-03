<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfractionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_infraction' => $this->id_infraction,
            'nature' => $this->nature,
            'type_infraction' => $this->type_infraction,
        ];
    }
}
