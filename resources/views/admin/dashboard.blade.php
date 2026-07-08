@extends('admin.layouts.navbar')
@section('title', 'Tableau de Bord - Recensement Pénitencier')
@section('suite')

  <div id="content" class="position-relative h-100">
    <div class="custom-container p-4" style="padding-top: 5rem !important;">

      {{-- Bandeau indiquant l'établissement sélectionné à la connexion --}}
      <div class="alert {{ ($typePrison ?? 'homme') === 'femme' ? 'alert-danger' : 'alert-primary' }} d-flex align-items-center mb-4 border-0 shadow-sm" role="alert">
        <i class="ti ti-building fs-4 me-3"></i>
        <div>
          <strong>{{ $libellePrison ?? 'Prison pour hommes' }}</strong>
          <span class="d-block small opacity-75">Vous consultez les données de cet établissement.</span>
        </div>
      </div>
      
      {{-- Cartes statistiques principales --}}
      <div class="row g-6 mb-6">
        
        {{-- Total Détenus --}}
       <div class="col-xl-4 col-md-6 col-12" >
          <div class="card card-lg bg-gradient-success border-0 shadow-sm text-dark">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Total Détenus Présents</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                  </svg>
                </div>
              </div>
             <a class='nav-link' href='{{ route('admin.search') }}'> <div class="lh-1">
                <div class="display-5 fw-bold mb-2">{{ $statsGlobales['total_presents'] ?? 0 }}</div>
                <p class="mb-0 small opacity-75">Recensés au sein de l'établissement</p>
              </div>
            </div></a>
          </div>
        </div>

        {{-- Sorties Prévues --}}
        <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-lg bg-gradient-info border-0 shadow-sm text-dark">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Sorties Prévues (Ce Mois)</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-logout">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3m0 6l3 -3" />
                  </svg>
                </div>
              </div>
              <div class="lh-1">
              <a class='nav-link' href='{{ route('admin.sortie.listes') }}'>  <div class="display-5 fw-bold mb-2">{{ sprintf('%02d', $statsGlobales['sorties_mois'] ?? 0) }}</div>
                <p class="mb-0 small opacity-75">Calcul automatique des fins de peines</p>
              </div>
            </div></a>
          </div>
        </div>

        {{-- Décès Enregistrés --}}
        <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-lg bg-gradient-danger border-0 shadow-sm text-dark">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Décès Enregistrés</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-square-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" /><path d="M10 10l4 4m0 -4l-4 4" />
                  </svg>
                </div>
              </div>
              <div class="lh-1">
               <a class='nav-link' href='{{ route('admin.deces.listes') }}'><div class="display-5 fw-bold mb-2">{{ sprintf('%02d', $statsGlobales['total_deces'] ?? 0) }}</div>
                <p class="mb-0 small opacity-75">Inscrits au registre spécifique d'édition</p>
              </div>
            </div></a> 
          </div>
        </div>

      </div>

      {{-- Sections intermédiaires : Infractions & Tranches d'âge --}}
      <div class="row g-6 mb-6">
        
        {{-- Tableau Dynamique des Infractions --}}
        <div class="col-xl-6 col-12">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3">
              <h5 class="mb-0 fw-bold text-dark">Répartition par Type d'Infraction</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-centered table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Nature de l'infraction</th>
                      <th class="text-end">Nombre de Détenus</th>
                      <th class="text-end">Pourcentage</th>
                    </tr>
                  </thead>
                  <tbody>
                   @forelse(collect($infractionsRepartition ?? []) as $infraction)
                      <tr>
                        <td class="fw-semibold">{{ $infraction->motif ?? 'Non spécifiée' }}</td>
                        <td class="text-end">{{ $infraction->total }}</td>
                        <td class="text-end">
                          <span class="badge bg-primary-subtle text-primary">
                            {{ number_format(($infraction->total / max($statsGlobales['total_presents'] ?? 0, 1)) * 100, 1) }}%
                          </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-center text-muted">Aucune donnée disponible</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        {{-- Barre de progression Dynamique des Tranches d'Âge --}}
        <div class="col-xl-6 col-12">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3">
              <h5 class="mb-0 fw-bold text-dark">Répartition par Tranche d'Âge</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
              
              @php
                $classesProgress = ['mineurs' => 'bg-warning', 'jeunes' => 'bg-info', 'adultes' => 'bg-primary', 'seniors' => 'bg-success'];
                $libellesAge = [
                    'mineurs' => 'Mineurs (Moins de 18 ans)',
                    'jeunes' => 'Jeunes Adultes (18 - 25 ans)',
                    'adultes' => 'Adultes (26 - 50 ans)',
                    'seniors' => 'Séniors (Plus de 50 ans)'
                ];
              @endphp

              @foreach($tranchesAge ?? [] as $cle => $donnees)
                <div class="mb-4">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold text-secondary">{{ $libellesAge[$cle] ?? 'Inconnu' }}</span>
                    <span class="fw-bold text-dark">{{ $donnees['count'] ?? 0 }} détenus ({{ number_format($donnees['pourcentage'] ?? 0, 1) }}%)</span>
                  </div>
                  <div class="progress" style="height: 8px">
                    <div class="progress-bar {{ $classesProgress[$cle] ?? 'bg-secondary' }}" role="progressbar" style="width: {{ $donnees['pourcentage'] ?? 0 }}%" aria-valuenow="{{ $donnees['pourcentage'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        </div>

      </div>

      {{-- Tableau des Prochaines Sorties Attendues --}}
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
              <h5 class="mb-0 fw-bold text-dark">Prochaines Sorties Attendues (Aperçu)</h5>
              <span class="badge bg-danger-subtle text-danger">Action Requise</span>
            </div>
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 table-centered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>NINA / ID</th>
                    <th>Nom Complet</th>
                    <th>Infraction Légale</th>
                    <th>Date d'Entrée</th>
                    <th>Temps Passé</th>
                    <th>Temps Restant</th>
                    <th>Date de Sortie Prévue</th>
                  </tr>
                </thead>
                <tbody>
                 @forelse($prochainesSorties ?? [] as $detenu)
                  <tr>
                    <td><span class="text-muted fw-mono">{{ $detenu->matricule_ou_nina }}</span></td>
                    <td class="fw-semibold">{{ Str::upper($detenu->nom) }} {{ Str::headline($detenu->prenom) }}</td>
                    <td>{{ $detenu->infraction ?? 'Non spécifiée' }}</td>
                    
                    {{-- 1. Affichage de la Date d'entrée --}}
                    <td>
                      @if($detenu->date_entree)
                        {{ \Carbon\Carbon::parse($detenu->date_entree)->translatedFormat('d M Y') }}
                      @elseif($detenu->condamnationPrincipale)
                        {{ \Carbon\Carbon::parse($detenu->condamnationPrincipale->date_debut_peine)->translatedFormat('d M Y') }}
                      @else
                        -
                      @endif
                    </td>

                    {{-- 2. Temps passé --}}
                    <td>
                      @if($detenu->temps_passe)
                        {{ trim(str_replace(['avant', 'Il y a', 'il y a'], '', $detenu->temps_passe)) }}
                      @else
                        -
                      @endif
                    </td>

                    {{-- 3. Temps restant avec arrondi en mois entier --}}
                    <td>
                      @php
                        $condamnation = $detenu->condamnationPrincipale;
                        $joursRestants = null;
                        $moisRestants = null;
                        if ($condamnation && $condamnation->fin_peine) {
                            $dateFin = \Carbon\Carbon::parse($condamnation->fin_peine);
                            $joursRestants = \Carbon\Carbon::now()->diffInDays($dateFin, false);
                            $moisRestants = (int) \Carbon\Carbon::now()->diffInMonths($dateFin, false);
                        }
                      @endphp
                      
                      @if($joursRestants !== null)
                        @if($joursRestants <= 0)
                          <span class="badge bg-danger-subtle text-danger fw-bold">Libérable</span>
                        @elseif($joursRestants <= 30)
                          <span class="badge bg-danger-subtle text-danger fw-bold">{{ $joursRestants }} j</span>
                        @else
                          <span class="badge {{ $moisRestants <= 2 ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' }} fw-bold">
                            {{ $moisRestants }} mois
                          </span>
                        @endif
                      @else
                        <span class="badge bg-secondary-subtle text-secondary fw-bold">-</span>
                      @endif
                    </td>

                    {{-- 4. Date de sortie prévue --}}
                    <td class="{{ $joursRestants !== null && $joursRestants <= 7 ? 'text-danger' : 'text-dark' }} fw-bold">
                      @if($condamnation && $condamnation->fin_peine)
                        {{ \Carbon\Carbon::parse($condamnation->fin_peine)->translatedFormat('d M Y') }}
                      @else
                        -
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucune sortie attendue pour ce mois.</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <style>
    .bg-white-opacity {
      background-color: rgba(255, 255, 255, 0.2);
    }
  </style>

@endsection