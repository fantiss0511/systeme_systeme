<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation des données lors de l'enregistrement d'une condamnation.
 * Les identifiants infraction/juridiction doivent exister en base.
 */
class StoreCondamnationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_infraction' => ['required', 'exists:infractions,id_infraction'],
            'id_juridiction' => ['required', 'exists:juridictions,id_juridiction'],
            'date_debut_peine' => ['required', 'date'],
            'duree_peine_mois' => ['required', 'integer', 'min:1'],
        ];
    }
}
