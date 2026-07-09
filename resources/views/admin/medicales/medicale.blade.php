@extends('admin.layouts.navbar')
@section('title', 'Registre des Extractions Médicales')
@section('suite')

  <div id="content" class="position-relative h-100">
    <div class="custom-container p-4" style="padding-top: 5rem !important;">

      {{-- En-tête de la page avec titre et bouton d'action --}}
      <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
          <h3 class="mb-1 fw-bold text-dark">Extractions Médicales</h3>
          <p class="text-muted small mb-0">Gestion et suivi des bons de sortie pour motifs de santé (Urgences et RDV).</p>
        </div>
        <div>
         

          <a href="{{ route('admin.medicale.create') }}" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm static-danger-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-ambulance">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
              <path d="M6 10h4" />
              <path d="M8 8v4" />
            </svg>
            <span>Nouvelle Extraction</span>
          </a>
        </div>
      </div>

      {{-- Indicateurs de suivi médical --}}
      <div class="row g-6 mb-6">

        {{-- Total des sorties du mois --}}
        <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-lg border-0 shadow-sm text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Total Extractions (Mois)</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <i class="ti ti-heart-handshake fs-4"></i>
                </div>
              </div>
              <div class="lh-1">
                <div class="display-5 fw-bold mb-2">24</div>
                <p class="mb-0 small opacity-75">Sorties médicales validées au total</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Urgences Critiques Actives --}}
        <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-lg border-0 shadow-sm text-dark" style="background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%);">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Urgences Absolues</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <i class="ti ti-alert-triangle text-danger fs-4"></i>
                </div>
              </div>
              <div class="lh-1">
                <div class="display-5 fw-bold mb-2 text-danger">02</div>
                <p class="mb-0 small opacity-75 text-danger-emphasis fw-semibold">Transferts critiques vers CHU</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Détenus actuellement à l'hôpital --}}
        <div class="col-xl-4 col-md-6 col-12">
          <div class="card card-lg border-0 shadow-sm text-dark" style="background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%);">
            <div class="card-body d-flex flex-column gap-4">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Actuellement Hors Établissement</div>
                <div class="bg-white-opacity p-2 rounded-circle">
                  <i class="ti ti-building-hospital fs-4"></i>
                </div>
              </div>
              <div class="lh-1">
                <div class="display-5 fw-bold mb-2">03</div>
                <p class="mb-0 small opacity-75">Détenus sous surveillance à l'extérieur</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- Registre principal --}}
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
              <h5 class="mb-0 fw-bold text-dark">Suivi des Mouvements Médicaux</h5>
              <span class="badge bg-danger-subtle text-danger px-3 py-2 fw-bold">Escortes Actives</span>
            </div>

            <div class="table-responsive">
              <table class="table text-nowrap mb-0 table-centered table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>NINA / ID</th>
                    <th>Nom & Prénom</th>
                    <th>Type de Sortie</th>
                    <th>Destination / Hôpital</th>
                    <th>Heure de Départ</th>
                    <th>Heure de Retour</th>
                    <th>Escorte Assignée</th>
                    <th class="text-center">Statut</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  {{-- Cas 1 : Urgence Médicale --}}
                  <tr>
                    <td><span class="text-muted fw-mono small">11409573C</span></td>
                    <td class="fw-semibold text-dark">OUATTARA Souleymane</td>
                    <td>
                      <span class="badge bg-danger text-white fw-bold px-2 py-1">
                        <i class="ti ti-flame me-1"></i> URGENCE
                      </span>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark">CHU Point G</div>
                      <span class="d-block small text-muted">Service Cardiologie</span>
                    </td>
                    <td class="fw-semibold text-dark">09 Juil 2026 - 09:15</td>
                    <td class="text-muted">--:-- (En cours)</td>
                    <td>
                      <div class="small fw-semibold text-dark">Brigade Escorte Alpha</div>
                      <span class="d-block small text-muted">3 Surveillants armés</span>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-warning-subtle text-warning fw-bold px-3 py-1">Hospitalisé</span>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-light border" title="Imprimer le bon d'extraction">
                        <i class="ti ti-printer fs-5"></i>
                      </button>
                    </td>
                  </tr>

                  {{-- Cas 2 : RDV médical programmé --}}
                  <tr>
                    <td><span class="text-muted fw-mono small">10485923A</span></td>
                    <td class="fw-semibold text-dark">KEITA Moussa</td>
                    <td>
                      <span class="badge bg-info-subtle text-info fw-bold px-2 py-1">
                        <i class="ti ti-calendar me-1"></i> RDV Clinique
                      </span>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark">Hôpital Gabriel Touré</div>
                      <span class="d-block small text-muted">Consultation Ophtalmo</span>
                    </td>
                    <td class="text-muted">08 Juil 2026 - 14:00</td>
                    <td class="text-success fw-semibold">08 Juil 2026 - 16:30</td>
                    <td>
                      <div class="small text-muted">Sgt. COULIBALY + 1 agent</div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-success-subtle text-success fw-bold px-3 py-1">Réintégré</span>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-light border" title="Imprimer le bon d'extraction">
                        <i class="ti ti-printer fs-5"></i>
                      </button>
                    </td>
                  </tr>

                  {{-- Cas 3 : Autre Urgence --}}
                  <tr>
                    <td><span class="text-muted fw-mono small">20948311B</span></td>
                    <td class="fw-semibold text-dark">DIALLO Aminata</td>
                    <td>
                      <span class="badge bg-danger text-white fw-bold px-2 py-1">
                        <i class="ti ti-flame me-1"></i> URGENCE
                      </span>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark">Pavillon Spécial de Santé</div>
                      <span class="d-block small text-muted">Maternité / Urgence</span>
                    </td>
                    <td class="fw-semibold text-dark">09 Juil 2026 - 06:40</td>
                    <td class="text-muted">--:-- (En cours)</td>
                    <td>
                      <div class="small fw-semibold text-dark">Équipe Médicale Intérieure</div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-warning-subtle text-warning fw-bold px-3 py-1">Hospitalisé</span>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-light border" title="Imprimer le bon d'extraction">
                        <i class="ti ti-printer fs-5"></i>
                      </button>
                    </td>
                  </tr>

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
      background-color: rgba(255, 255, 255, 0.25);
    }
    .fw-mono {
      font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
    /* Garde le bouton rouge urgence actif en toutes circonstances */
    .static-danger-btn,
    .static-danger-btn:hover,
    .static-danger-btn:active,
    .static-danger-btn:focus {
      background-color: var(--bs-danger) !important;
      border-color: var(--bs-danger) !important;
      color: #ffffff !important;
      opacity: 1 !important;
    }
  </style>

  <style>
  /* Force la couleur Rouge Urgence de manière permanente (Même au survol ou clic) */
  .static-danger-btn, 
  .static-danger-btn:hover, 
  .static-danger-btn:active, 
  .static-danger-btn:focus,
  .static-danger-btn:focus-visible {
    background-color: #dc3545 !important; /* Rouge Bootstrap standard */
    border-color: #dc3545 !important;
    color: #ffffff !important; /* Texte blanc */
    opacity: 1 !important;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
  }

  /* Force la couleur de l'icône SVG à l'intérieur */
  .static-danger-btn svg {
    stroke: #ffffff !important;
  }
</style>

@endsection
