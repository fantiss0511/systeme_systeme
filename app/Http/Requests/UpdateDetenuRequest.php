<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validation des données lors de la modification d'un détenu existant.
 * Tous les champs sont optionnels (mise à jour partielle).
 */
class UpdateDetenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nina = $this->route('detenu');

        return [
            'matricule_ou_nina' => [
                'sometimes',
                'string',
                'max:30',
                // Ignore le détenu en cours de modification pour la règle unique
                Rule::unique('detenus', 'matricule_ou_nina')->ignore($nina, 'matricule_ou_nina'),
            ],
            'nom' => ['sometimes', 'string', 'max:255'],
            'prenom' => ['sometimes', 'string', 'max:255'],
            'date_naissance' => ['sometimes', 'date', 'before:today'],
            'sexe' => ['sometimes', Rule::in(['M', 'F'])],
            'photo' => ['nullable', 'string', 'max:500'],
            'statut' => ['sometimes', Rule::in(['present', 'libere', 'decede'])],
        ];
    }
}
