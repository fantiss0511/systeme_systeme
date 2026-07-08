<?php

namespace App\Http\Controllers;

use App\Models\Infraction;
use Illuminate\Http\Request;

class InfractionController extends Controller
{
    // Afficher la liste des infractions
    public function index()
    {
        $infractions = Infraction::orderBy('type_infraction')->get();

        return view('admin.Infractions.infraction', compact('infractions'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.Infractions.create');
    }

    // Enregistrer le type d'infraction dans la base de données
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_infraction' => 'required|string|max:255',
            'nature'          => 'nullable|string|max:255',
        ], [
            'type_infraction.required' => "Le type d'infraction est obligatoire.",
        ]);

        if (empty($validated['nature'])) {
            $validated['nature'] = 'Non spécifiée';
        }

        Infraction::create($validated);

        return redirect()
            ->route('admin.infraction.index')
            ->with('success', "Le type d'infraction a été enregistré avec succès !");
    }

    public function destroy($id_infraction)
    {
        $infraction = Infraction::findOrFail($id_infraction);
        $infraction->delete();

        return redirect()
            ->route('admin.infraction.index')
            ->with('success', "L'infraction a été supprimée avec succès.");
    }
}