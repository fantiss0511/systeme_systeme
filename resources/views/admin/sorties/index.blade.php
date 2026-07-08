@extends('admin.layouts.navbar')
@section('title', 'Sorties Prévues du Mois')
@section('suite')

@php
  // SÉCURITÉ 1 : Si le contrôleur oublie la période
  if (!isset($periodeEvaluation)) {
      \Carbon\Carbon::setLocale('fr');
      $periodeEvaluation = \Carbon\Carbon::now()->translatedFormat('F Y');
  }

  // SÉCURITÉ 2 : Si le contrôleur oublie d'envoyer la liste des détenus
  if (!isset($detenus)) {
      $detenus = collect(); // Crée une collection vide pour éviter l'erreur 500
  }
@endphp

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Libérations du Mois</h3>
        <p class="mb-0 text-secondary">Période d'évaluation : <span class="fw-bold text-primary">{{ $periodeEvaluation }}</span></p>
      </div>
      <a href="#" class="btn btn-white border shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
          <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
          <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
        </svg> Exporter la liste
      </a>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 table-centered table-hover">
          <thead class="table-light">
            <tr>
              <th>NINA / Matricule</th>
              <th>Nom & Prénom</th>
              <th>Infraction Initiale</th>
              <th>Durée Totale Peine</th>
              <th>Date Début</th>
              <th class="text-center">Jours Restants</th>
              <th class="text-end">Date de Sortie Prévue</th>
            </tr>
          </thead>
          <tbody>
            @forelse($detenus as $detenu)
              @php
                $condamnation = $detenu->condamnationPrincipale;
                $finPeine = $condamnation->fin_peine ?? null;
                $joursRestants = $finPeine ? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($finPeine), false) : null;
              @endphp
              <tr>
                <td><span class="fw-mono text-muted">{{ $detenu->matricule_ou_nina }}</span></td>
                <td class="fw-bold text-dark">{{ $detenu->nom }} {{ $detenu->prenom }}</td>
                <td>{{ $condamnation->infraction ?? 'Non spécifiée' }}</td>
                <td>{{ $condamnation->duree_peine ?? '--' }} Mois</td>
                <td>
                  @if($condamnation && $condamnation->date_debut)
                    {{ \Carbon\Carbon::parse($condamnation->date_debut)->translatedFormat('d F Y') }}
                  @else
                    --
                  @endif
                </td>
                <td class="text-center">
                  @if(!is_null($joursRestants))
                    @if($joursRestants <= 5)
                      <span class="badge bg-danger text-white fs-6 px-3">{{ (int)$joursRestants }} jours</span>
                    @else
                      <span class="badge bg-warning text-dark fs-6 px-3">{{ (int)$joursRestants }} jours</span>
                    @endif
                  @else
                    <span class="text-muted">--</span>
                  @endif
                </td>
                <td class="text-end fw-bold text-dark">
                  @if($finPeine)
                    {{ \Carbon\Carbon::parse($finPeine)->translatedFormat('d F Y') }}
                  @else
                    --
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">Aucune libération prévue pour ce mois.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection