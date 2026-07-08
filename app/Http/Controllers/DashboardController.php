<?php

namespace App\Http\Controllers;

use App\Models\Detenu;
use App\Models\Juridiction;
use App\Models\Infraction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Contrôleur des pages du tableau de bord administrateur.
class DashboardController extends Controller
{
    //Affiche le tableau de bord principal avec les statistiques dynamiques calculées.
    public function dashboard(Request $request): View
    {
        $typePrison = $request->session()->get('type_prison', 'homme');
        $libellePrison = $typePrison === 'femme' ? 'Prison pour femmes' : 'Prison pour hommes';
        $sexeCible = $typePrison === 'femme' ? 'F' : 'M';

        // Statistiques globales de l'établissement ciblé
        $statsGlobales = [
            'total_presents' => Detenu::where('sexe', $sexeCible)->where('statut', 'present')->count(),
            'sorties_mois'   => Detenu::where('sexe', $sexeCible)->sortiesPrevuesMois(now()->month, now()->year)->count(),
            'total_deces'    => Detenu::where('sexe', $sexeCible)->decede()->count(),
        ];

        // Répartition des infractions
        $infractionsRepartition = DB::table('condamnations')
            ->join('detenus', 'condamnations.matricule_detenu', '=', 'detenus.matricule_ou_nina')
            ->join('infractions', 'condamnations.id_infraction', '=', 'infractions.id_infraction')
            ->where('detenus.sexe', $sexeCible)
            ->where('detenus.statut', 'present')
            ->select('infractions.id_infraction', 'infractions.nature as motif', DB::raw('count(*) as total'))
            ->groupBy('infractions.id_infraction', 'infractions.nature')
            ->get();

        // Calcul des tranches d'âge via les dates de naissance
        $detenusPourAge = Detenu::where('sexe', $sexeCible)->where('statut', 'present')->get(['date_naissance']);
        $countsAge = ['mineurs' => 0, 'jeunes' => 0, 'adultes' => 0, 'seniors' => 0];

        foreach ($detenusPourAge as $d) {
            if ($d->date_naissance) {
                $age = Carbon::parse($d->date_naissance)->age;
                if ($age < 18) $countsAge['mineurs']++;
                elseif ($age <= 25) $countsAge['jeunes']++;
                elseif ($age <= 50) $countsAge['adultes']++;
                else $countsAge['seniors']++;
            }
        }

        $tranchesAge = [];
        foreach ($countsAge as $cle => $count) {
            $tranchesAge[$cle] = [
                'count' => $count,
                'pourcentage' => $statsGlobales['total_presents'] > 0 ? ($count / $statsGlobales['total_presents']) * 100 : 0
            ];
        }

        // Les prochaines sorties attendues
        $prochainesSorties = Detenu::where('sexe', $sexeCible)
            ->where('statut', 'present')
            ->whereHas('condamnations')
            ->take(5)
            ->get();

        
        foreach ($prochainesSorties as $detenu) {
            $maintenant = Carbon::now();
            $condamnation = $detenu->condamnationPrincipale()->first();

            if ($condamnation) {
                $infractionBdd = DB::table('infractions')->where('id_infraction', $condamnation->id_infraction)->first();
                $detenu->infraction = $infractionBdd->nature ?? 'Non spécifiée';
                
                $detenu->peine_annees = round($condamnation->duree_peine_mois / 12, 1);
                $dateSortie = Carbon::parse($condamnation->fin_peine);
                $dateEntree = Carbon::parse($condamnation->date_debut_peine);
                
                
                $detenu->temps_passe = (int)$dateEntree->diffInMonths($maintenant) . ' mois';
                
                // Temps restant converti en mois
                if ($maintenant->greaterThanOrEqualTo($dateSortie)) {
                    $detenu->temps_restant = "Libérable";
                } else {
                    $moisRestants = $maintenant->diffInMonths($dateSortie);
                    $detenu->temps_restant = (int)$moisRestants === 0 
                        ? $maintenant->diffInDays($dateSortie) . ' j' 
                        : $moisRestants . ' mois';
                }
            } else {
                $detenu->infraction = 'Aucune';
                $detenu->peine_annees = 0;
                $detenu->temps_restant = '-';
                $detenu->temps_passe = '0 mois';
            }
        }

        return view('admin.dashboard', compact(
            'typePrison', 
            'libellePrison', 
            'statsGlobales', 
            'infractionsRepartition', 
            'tranchesAge', 
            'prochainesSorties'
        ));
    }

    //Intercepte et traite la soumission du Formulaire d'Enregistrement 

  public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'nom'               => 'required|string|max:255',
        'prenom'            => 'required|string|max:255',
        'matricule_ou_nina' => 'required|string|unique:detenus,matricule_ou_nina',
        'date_naissance'    => 'required|date|before:today',
        'sexe'              => 'required|in:M,F',
        'statut_matrimonial'=> 'required|string|max:255',
        'photo'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'id_infraction'     => 'required|exists:infractions,id_infraction',
        'id_juridiction'    => 'required|exists:juridictions,id_juridiction',
        'date_entree'       => 'required|date',
        'duree_peine_mois'  => 'required|integer|min:1',
    ]);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('photos_detenus', 'public');
    }

    $detenu = Detenu::create([
        'matricule_ou_nina'  => $validated['matricule_ou_nina'],
        'nom'                => $validated['nom'],
        'prenom'             => $validated['prenom'],
        'date_naissance'     => $validated['date_naissance'],
        'sexe'               => $validated['sexe'],
        'statut_matrimonial' => $validated['statut_matrimonial'],
        'photo'              => $validated['photo'] ?? null,
        'statut'             => 'present',
    ]);

    $dateEntree = Carbon::parse($validated['date_entree']);
    $dateSortie = $dateEntree->copy()->addMonths((int) $validated['duree_peine_mois']);

    $detenu->condamnations()->create([
        'id_infraction'    => $validated['id_infraction'],
        'id_juridiction'   => $validated['id_juridiction'],
        'date_debut_peine' => $validated['date_entree'],
        'duree_peine_mois' => $validated['duree_peine_mois'],
        'fin_peine'        => $dateSortie,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Le détenu à été enregistrés avec succès.');
}

    // Recherche multicritère des détenus
public function search(Request $request): View
{
    $nom = trim($request->input('nom'));
    $nina = trim($request->input('nina'));
    $dateEntree = $request->input('date_entree');

    $detenus = Detenu::query()
        ->search($nom, $nina, $dateEntree)
        ->with(['condamnations.infraction', 'condamnations.juridiction']) 
        ->get();

    $maintenant = Carbon::now();

    $detenus->each(function ($detenu) use ($maintenant) {
        $condamnation = $detenu->condamnations->first(); 
        
        $detenu->nina = $detenu->matricule_ou_nina;
        $detenu->genre = $detenu->sexe === 'M' ? 'Masculin' : 'Féminin';

        if ($condamnation) {
            $detenu->infraction = $condamnation->infraction->nature ?? 'Non spécifiée';
            $detenu->juridiction = $condamnation->juridiction->nom ?? 'Non spécifiée';
            
            $detenu->date_entree = $condamnation->date_debut_peine;
            $detenu->peine_annees = round($condamnation->duree_peine_mois / 12, 1);
            $detenu->date_sortie_prevue = $condamnation->fin_peine;

            $cDateEntree = Carbon::parse($condamnation->date_debut_peine);
            $cDateSortie = Carbon::parse($condamnation->fin_peine);

            $detenu->temps_passe = (int)$cDateEntree->diffInMonths($maintenant) . ' mois';

            if ($maintenant->greaterThanOrEqualTo($cDateSortie)) {
                $detenu->temps_restant = "Libérable";
            } else {
                $moisRestants = $maintenant->diffInMonths($cDateSortie);
                
                if ($moisRestants === 0) {
                    $detenu->temps_restant = $maintenant->diffInDays($cDateSortie) . ' j';
                } else {
                    $detenu->temps_restant = $moisRestants . ' mois';
                }
            }
        } else {
            $detenu->infraction = 'Aucune';
            $detenu->juridiction = '-';
            $detenu->date_entree = null;
            $detenu->peine_annees = 0;
            $detenu->date_sortie_prevue = null;
            $detenu->temps_passe = '0 mois';
            $detenu->temps_restant = '-';
        }
    });

    return view('admin.detenus.index', compact('detenus'));
}
    /**
     * Affiche le formulaire d'enregistrement d'un détenu
     */
    public function create(): View
    {
        $genres = ['M' => 'Masculin', 'F' => 'Féminin'];
        $statuts = ['present' => 'Présent', 'transfere' => 'Transféré'];
        
        // Récupération de toutes les infractions et juridictions pour alimenter la vue
        $infractions = Infraction::all();
        $juridictions = Juridiction::all(); 

        return view('admin.detenus.create', compact('genres', 'statuts', 'infractions', 'juridictions'));
    }

    /**
     * Affiche les listes des sorties prévues
     */
    public function typeofPrisonListes(Request $request): View
    {
        return $this->sortieListes($request);
    }

    public function sortieListes(Request $request): View
    {
        $typePrison = $request->session()->get('type_prison', 'homme');
        $sexeCible = $typePrison === 'femme' ? 'F' : 'M';

        $mois = now()->month;
        $annee = now()->year;

        $sortiesPrevues = Detenu::query()
            ->where('sexe', $sexeCible)
            ->sortiesPrevuesMois($mois, $annee)
            ->with('condamnations')
            ->get();

        return view('admin.sorties.index', compact('sortiesPrevues', 'typePrison'));
    }

    /**
     * Affiche la liste des décès enregistrés
     */
    public function decesListes(Request $request): View
    {
        $typePrison = $request->session()->get('type_prison', 'homme');
        $sexeCible = $typePrison === 'femme' ? 'F' : 'M';

        $detenusDecedes = Detenu::query()
            ->where('sexe', $sexeCible)
            ->decede()
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.deces.index', compact('detenusDecedes', 'typePrison'));
    }
   /**
 * Affiche le profil détaillé d'un détenu unique
 */
public function show(Detenu $detenu): View
{
    $detenu->load(['condamnations' => function ($query) {
        $query->orderByDesc('date_debut_peine')
              ->with(['infraction', 'juridiction']);
    }]);

    $condamnationActuelle = $detenu->condamnationPrincipale()
        ->with(['infraction', 'juridiction'])
        ->first();

    return view('admin.detenus.show', compact('detenu', 'condamnationActuelle'));
}
    /**
     * Affiche l'interface de modification des informations d'un détenu
     */
    public function edit(Detenu $detenu): View
    {
        $genres = ['M' => 'Masculin', 'F' => 'Féminin'];
        $statuts = ['present' => 'Présent', 'decede' => 'Décédé', 'libere' => 'Libéré'];
        $condamnation = $detenu->condamnationPrincipale()->first();

        return view('admin.detenus.edit', compact('detenu', 'genres', 'statuts', 'condamnation'));
    }

    /**
     * Traite et enregistre les modifications de la fiche d'enregistrement
     */
    public function update(Request $request, Detenu $detenu): RedirectResponse
    {
        $validated = $request->validate([
            'nom'               => 'required|string|max:255',
            'prenom'            => 'required|string|max:255',
            'matricule_ou_nina' => 'required|string|unique:detenus,matricule_ou_nina,' . $detenu->matricule_ou_nina . ',matricule_ou_nina',
            'date_naissance'    => 'required|date|before:today',
            'sexe'              => 'required|in:M,F',
            'statut'            => 'required|string',
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'motif_infraction'  => 'required|string|max:255',
            'juridiction'       => 'required|string|max:255',
            'date_entree'       => 'required|date',
            'duree_peine_mois'  => 'required|integer|min:1',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos_detenus', 'public');
        } else {
            $validated['photo'] = $detenu->photo;
        }

        $detenu->update([
            'matricule_ou_nina' => $validated['matricule_ou_nina'],
            'nom'               => $validated['nom'],
            'prenom'            => $validated['prenom'],
            'date_naissance'    => $validated['date_naissance'],
            'sexe'              => $validated['sexe'],
            'statut'            => $validated['statut'],
            'photo'             => $validated['photo'],
        ]);

        DB::table('infractions')->updateOrInsert(
            ['nature' => $validated['motif_infraction']],
            ['type_infraction' => 'Non spécifié', 'updated_at' => now(), 'updated_at' => now()]
        );
        $infraction = DB::table('infractions')->where('nature', $validated['motif_infraction'])->first();

        DB::table('juridictions')->updateOrInsert(
            ['nom' => $validated['juridiction']],
            ['created_at' => now(), 'updated_at' => now()]
        );
        $juridiction = DB::table('juridictions')->where('nom', $validated['juridiction'])->first();

        $dateEntree = Carbon::parse($validated['date_entree']);
        $dateSortie = $dateEntree->copy()->addMonths((int)$validated['duree_peine_mois']);

        $detenu->condamnations()->updateOrCreate(
            ['matricule_detenu' => $detenu->matricule_ou_nina],
            [
                'id_infraction'     => $infraction->id_infraction,
                'id_juridiction'    => $juridiction->id_juridiction,
                'date_debut_peine'  => $validated['date_entree'],
                'duree_peine_mois'  => $validated['duree_peine_mois'],
                'fin_peine'         => $dateSortie,
            ]
        );

        return redirect()->route('admin.dashboard')->with('success', 'Le dossier écrou a été mis à jour avec succès.');
    }

    //Supprime définitivement la fiche d'un détenu
     
    public function destroy(Detenu $detenu): RedirectResponse
    {
        $detenu->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Fiche du détenu supprimée définitivement.');
    }

    // --- INFRACTIONS ---
    public function indexInfraction() {
        $infractions = Infraction::all();
        return view('admin.Infractions.infraction', compact('infractions'));
    }

    public function createInfraction() {
        return view('admin.Infractions.create'); 
    }

    public function storeInfraction(Request $request) {
        $request->validate([
            'nature' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $input = $request->all();
        Infraction::create($input);
        return redirect()->route('admin.infraction.index')->with('success', 'Infraction créée avec succès !');
    }

    // --- JURIDICTIONS ---
    public function indexJuridiction()
    {
        $juridictions = Juridiction::all();
        return view('admin.juridiction.juridiction', compact('juridictions'));    
    }

    public function createJuridiction()
    {
        return view('admin.juridiction.create');
    }

    public function storeJuridiction(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'quartier' => 'required|string|max:255',
        ]);

        Juridiction::create([
            'nom' => $request->nom,
            'ville' => $request->ville,
            'quartier' => $request->quartier,
        ]);

        return redirect()->route('admin.juridiction.index')->with('success', 'Juridiction enregistrée avec succès !');
    }

    public function destroyJuridiction($id_juridiction)
    {
        $juridiction = Juridiction::findOrFail($id_juridiction);
        $juridiction->delete();
        return redirect()->route('admin.juridiction.index')->with('success', 'La juridiction a été supprimée avec succès !');
    }
   
public function typesInfraction()
{  
    $infractions = \App\Models\Infraction::all(); 
    return view('admin.Infractions.types', compact('infractions')); 
}
}