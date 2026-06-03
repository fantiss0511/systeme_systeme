<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validation des données lors de l'enregistrement d'un nouveau détenu.
 */
class StoreDetenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'matricule_ou_nina' => ['required', 'string', 'max:30', 'unique:detenus,matricule_ou_nina'],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'photo' => ['nullable', 'string', 'max:500'], // Chemin ou URL de la photo
            'statut' => ['sometimes', Rule::in(['present', 'libere', 'decede'])],
        ];
    }
}
