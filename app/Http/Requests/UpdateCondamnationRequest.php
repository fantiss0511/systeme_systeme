<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation des données lors de la modification d'une condamnation.
 * La fin de peine sera recalculée automatiquement si la durée ou la date change.
 */
class UpdateCondamnationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_infraction' => ['sometimes', 'exists:infractions,id_infraction'],
            'id_juridiction' => ['sometimes', 'exists:juridictions,id_juridiction'],
            'date_debut_peine' => ['sometimes', 'date'],
            'duree_peine_mois' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
