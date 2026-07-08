@extends('admin.layouts.navbar')
@section('title', 'Fiche de Synthèse - Détenu')
@section('suite')

{{-- variables dynamiques pour le suivi de la peine --}}
@php
    $progress = 0;
    $tempsPasse = "Non démarrée";
    $tempsRestant = "Non calculé";

    if ($condamnationActuelle && $condamnationActuelle->date_debut_peine && $condamnationActuelle->fin_peine) {
        $debut = \Carbon\Carbon::parse($condamnationActuelle->date_debut_peine);
        $fin = \Carbon\Carbon::parse($condamnationActuelle->fin_peine);
        $aujourdhui = \Carbon\Carbon::now();

        // Sécurité si la date du jour est antérieure au début officiel
        if ($aujourdhui->greaterThanOrEqualTo($debut)) {
            $totalJours = $debut->diffInDays($fin);
            $joursPasses = $debut->diffInDays($aujourdhui);

            // Calcul du pourcentage de progression (bridé à 100% max)
            $progress = $totalJours > 0 ? min(round(($joursPasses / $totalJours) * 100), 100) : 0;

            // Calcul humain du temps passé
            $diffPasse = $debut->diff($aujourdhui);
            $ansPasse = $diffPasse->y > 0 ? $diffPasse->y . ' an(s) ' : '';
            $moisPasse = $diffPasse->m > 0 ? $diffPasse->m . ' mois' : '';
            $tempsPasse = trim($ansPasse . $moisPasse) ?: "Quelques jours";

            // Calcul humain du temps restant (ou libération)
            if ($aujourdhui->greaterThanOrEqualTo($fin)) {
                $tempsRestant = "Libérable (Peine purgée)";
            } else {
                $diffFutur = $aujourdhui->diff($fin);
                $ansFutur = $diffFutur->y > 0 ? $diffFutur->y . ' an(s) ' : '';
                $moisFutur = $diffFutur->m > 0 ? $diffFutur->m . ' mois ' : '';
                $joursFutur = $diffFutur->d > 0 && $diffFutur->y == 0 ? $diffFutur->d . ' jour(s)' : '';
                $tempsRestant = trim($ansFutur . $moisFutur . $joursFutur) ?: "Moins d'un jour";
            }
        } else {
            $tempsRestant = "Incarcération future";
        }
    }
@endphp

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">

    {{-- Bouton de retour --}}
    <div class="mb-4">
      <a href="{{ route('admin.search') }}" class="btn btn-light border btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-left me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
        Retour à la liste
      </a>
    </div>

    <div class="row g-4">

      {{-- Colonne Gauche : Profil & Progression --}}
      <div class="col-xl-4 col-lg-5 col-12">

        <div class="card border-0 shadow-sm text-center mb-6">
          <div class="card-body py-5">
            <div class="mb-4">
              @if($detenu->photo)
                <img src="{{ asset('storage/' . $detenu->photo) }}" alt="Photo Détenu" class="avatar avatar-xxl rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
              @else
                <img src="{{ asset('dasher/dash/assets/images/avatar/avatar-1.jpg') }}" alt="Photo par défaut" class="avatar avatar-xxl rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
              @endif
            </div>
            <h4 class="mb-1 fw-bold text-dark">{{ $detenu->prenom }} {{ $detenu->nom }}</h4>

            @if($detenu->statut === 'present' || $detenu->statut === 'En Détention')
              <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">En Détention</span>
            @else
              <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold">{{ $detenu->statut }}</span>
            @endif

            <div class="mt-4 pt-3 border-top text-start">
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Numéro NINA / Matricule :</span>
                <span class="fw-mono fw-bold text-dark">{{ $detenu->matricule_ou_nina }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Statut Pénal :</span>
                <span class="fw-semibold text-dark">Condamné</span>
              </div>
            </div>
          </div>
        </div>

        {{-- Suivi de la peine  --}}
        <div class="card border-0 shadow-sm bg-light">
          <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="mb-0 fw-bold text-dark">Suivi de la Durée de Peine</h5>
          </div>
          <div class="card-body">
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold text-secondary">Progression de la peine</span>
                <span class="fw-bold text-primary">{{ $progress }}% effectuée</span>
              </div>
              <div class="progress" style="height: 10px">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="d-flex flex-column gap-3">
              <div class="p-3 bg-white rounded border border-dashed d-flex align-items-center gap-3">
                <div class="icon-shape bg-success-subtle text-success p-2 rounded-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-clock-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" /><path d="M12 7v5l2 2" /><path d="M15 19l2 2l4 -4" /></svg>
                </div>
                <div>
                  <div class="text-muted small">Temps déjà passé</div>
                  <div class="fw-bold text-dark fs-6">{{ $tempsPasse }}</div>
                </div>
              </div>

              <div class="p-3 bg-white rounded border border-dashed d-flex align-items-center gap-3">
                <div class="icon-shape bg-danger-subtle text-danger p-2 rounded-circle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-hourglass-high"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /><path d="M8 9h8" /></svg>
                </div>
                <div>
                  <div class="text-muted small">Temps restant avant libération</div>
                  <div class="fw-bold text-danger fs-6">{{ $tempsRestant }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- Informations détaillées --}}
      <div class="col-xl-8 col-lg-7 col-12">

        {{-- 1. État civil --}}
        <div class="card border-0 shadow-sm mb-6">
          <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">1. Registre d'État Civil</h5>
            <a href="{{ route('admin.detenus.edit', $detenu) }}" class="btn btn-sm btn-white border text-primary d-inline-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-pencil me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
              Modifier la fiche
            </a>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-6">
                <span class="text-muted small d-block">Nom complet</span>
                <span class="fw-semibold text-dark fs-5">{{ strtoupper($detenu->nom) }} {{ $detenu->prenom }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted small d-block">Numéro d'Identité National (NINA) / Matricule</span>
                <span class="fw-mono fw-bold text-dark fs-5">{{ $detenu->matricule_ou_nina }}</span>
              </div>
              <div class="col-md-6">
                <span class="text-muted small d-block">Date de Naissance</span>
                <span class="fw-semibold text-dark">
                  {{ $detenu->date_naissance ? \Carbon\Carbon::parse($detenu->date_naissance)->translatedFormat('d F Y') : '-' }}
                  ({{ $detenu->date_naissance ? \Carbon\Carbon::parse($detenu->date_naissance)->age . ' ans' : '-' }})
                </span>
              </div>
              <div class="col-md-6">
                <span class="text-muted small d-block">Sexe</span>
                <span class="fw-semibold text-dark">
                  {{ $detenu->sexe === 'M' ? 'Masculin (M)' : ($detenu->sexe === 'F' ? 'Féminin (F)' : $detenu->sexe) }}
                </span>
              </div>
              @if($detenu->statut_matrimonial)
              <div class="col-md-6">
                <span class="text-muted small d-block">Statut Matrimonial</span>
                <span class="fw-semibold text-dark">{{ $detenu->statut_matrimonial }}</span>
              </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Situation Pénale --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="mb-0 fw-bold text-dark">2. Situation Pénale & Condamnation</h5>
          </div>
          <div class="card-body">
            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <span class="text-muted small d-block">Nature de l'infraction principale</span>
                <span class="fw-semibold text-dark fs-5">
                  {{ $condamnationActuelle && $condamnationActuelle->infraction ? $condamnationActuelle->infraction->nature : 'Non spécifiée' }}
                </span>
              </div>
              <div class="col-md-6">
                <span class="text-muted small d-block">Juridiction de jugement</span>
                <span class="fw-semibold text-dark fs-5">
                  {{ $condamnationActuelle && $condamnationActuelle->juridiction ? $condamnationActuelle->juridiction->nom : 'Non spécifiée' }}
                </span>
              </div>
              <div class="col-md-4">
                <span class="text-muted small d-block">Date de Début d'Incarcération</span>
                <span class="fw-semibold text-dark">
                  {{ $condamnationActuelle && $condamnationActuelle->date_debut_peine ? \Carbon\Carbon::parse($condamnationActuelle->date_debut_peine)->format('d/m/Y') : 'Non renseignée' }}
                </span>
              </div>
              <div class="col-md-4">
                <span class="text-muted small d-block">Peine Initiale Prononcée</span>
                <span class="fw-semibold text-dark">
                  {{ $condamnationActuelle ? $condamnationActuelle->duree_peine_mois . ' mois' : 'Non calculée' }}
                </span>
              </div>
              <div class="col-md-4">
                <span class="text-muted small d-block">Date de Sortie Automatique Calculée</span>
                <span class="fw-bold text-danger">
                  {{ $condamnationActuelle && $condamnationActuelle->fin_peine ? \Carbon\Carbon::parse($condamnationActuelle->fin_peine)->format('d/m/Y') : 'Inconnue' }}
                </span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

@endsection