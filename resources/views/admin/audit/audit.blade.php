@extends('admin.layouts.navbar')
@section('title', 'Journal d\'Audit et de Traçabilité')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4" style="padding-top: 5rem !important;">

    <div class="mb-5">
      <h3 class="mb-1 fw-bold text-dark">Journal d'Audit & Traçabilité Security</h3>
      <p class="text-muted small mb-0">Registre complet des actions, ajouts et modifications effectués par les agents pénitentiaires.</p>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark">Historique des Modifications Récentes</h5>
        <span class="badge bg-success-subtle text-success px-3 py-2 fw-bold">Flux en direct</span>
      </div>

      <div class="table-responsive">
        <table class="table text-nowrap mb-0 table-centered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>Date & Heure</th>
              <th>Agent Connecté</th>
              <th>Action Effectuée</th>
              <th>Cible / Détenu</th>
              <th>Ancienne Valeur</th>
              <th>Nouvelle Valeur</th>
              <th class="text-end">Adresse IP</th>
            </tr>
          </thead>
          <tbody>

            {{-- Audit 1 --}}
            <tr>
              <td class="fw-semibold text-dark">09 Juil 2026 - 10:15</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-primary-subtle text-primary rounded px-2 py-1 small fw-bold">CNE</div>
                  <div>
                    <span class="d-block fw-semibold text-dark">Capitaine COULIBALY</span>
                    <span class="d-block text-muted small">ID Agent: #AG-7729</span>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-warning-subtle text-warning fw-bold">Modification Peine</span></td>
              <td class="fw-semibold">DIALLO Aminata</td>
              <td class="text-danger decoration-line-through">18 mois</td>
              <td class="text-success fw-bold">12 mois (Grâce présidentielle)</td>
              <td class="text-end text-muted fw-mono small">192.168.1.45</td>
            </tr>

            {{-- Audit 2 --}}
            <tr>
              <td class="fw-semibold text-dark">09 Juil 2026 - 09:30</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-secondary-subtle text-secondary rounded px-2 py-1 small fw-bold">LTN</div>
                  <div>
                    <span class="d-block fw-semibold text-dark">Lieutenant SANOGO O.</span>
                    <span class="d-block text-muted small">ID Agent: #AG-8012</span>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-danger-subtle text-danger fw-bold">Archivage Dossier</span></td>
              <td class="fw-semibold">KEITA Moussa</td>
              <td class="text-muted">Écrou Actif</td>
              <td class="text-dark fw-bold">Archivé (Fin de peine)</td>
              <td class="text-end text-muted fw-mono small">192.168.1.12</td>
            </tr>

            {{-- Audit 3 --}}
            <tr>
              <td class="fw-semibold text-dark">08 Juil 2026 - 23:45</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-danger-subtle text-danger rounded px-2 py-1 small LINE-bold">MJR</div>
                  <div>
                    <span class="d-block fw-semibold text-dark">Major TRAORÉ Adama</span>
                    <span class="d-block text-muted small">ID Agent: #AG-0439</span>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-danger text-white fw-bold">Extraction Urgence</span></td>
              <td class="fw-semibold">OUATTARA Souleymane</td>
              <td class="text-muted">En Cellule</td>
              <td class="text-danger fw-bold">Transféré CHU (Urgence)</td>
              <td class="text-end text-muted fw-mono small">192.168.2.101</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
