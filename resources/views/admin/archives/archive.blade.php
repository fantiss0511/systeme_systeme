@extends('admin.layouts.navbar')
@section('title', 'Archives Historiques - Gestion Pénitentiaire')
@section('suite')

    <div id="content" class="position-relative h-100">
        <div class="custom-container p-4" style="padding-top: 5rem !important;">

            {{-- En-tête de la page avec titre et bouton d'action --}}
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h3 class="mb-1 fw-bold text-dark">Archives Générales</h3>
                    <p class="text-muted small mb-0">Registre historique des détenus libérés, transférés ou décédés.</p>
                </div>
                <div>
                    {{-- Bouton pour archiver manuellement un nouveau dossier --}}
                    <a href="{{ route('admin.archive.create') }}"
                        class="btn btn-secondary d-flex align-items-center gap-2 shadow-sm static-primary-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icon-tabler-archive-filled">
                            <path
                                d="M19 2a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-2a3 3 0 0 1 3 -3zm-14 10h14a1 1 0 0 1 1 1v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a1 1 0 0 1 1 -1zm5 2a1 1 0 0 0 0 2h4a1 1 0 0 0 0 -2z"
                                fill="currentColor" stroke-width="0" />
                        </svg>
                        <span>Archiver un dossier</span>
                    </a>
                </div>
            </div>

            <div class="row g-6 mb-6">

                {{-- Total Dossiers Archivés --}}
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card card-lg border-0 shadow-sm text-dark"
                        style="background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);">
                        <div class="card-body d-flex flex-column gap-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Total Dossiers Archivés
                                </div>
                                <div class="bg-white-opacity p-2 rounded-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-archive"
                                        width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                        <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
                                        <path d="M10 12l4 0" />
                                    </svg>
                                </div>
                            </div>
                            <div class="lh-1">
                                <div class="display-5 fw-bold mb-2">142</div>
                                <p class="mb-0 small opacity-75">Historique cumulé de l'établissement</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Libérations & Fins de Peine --}}
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card card-lg border-0 shadow-sm text-dark"
                        style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);">
                        <div class="card-body d-flex flex-column gap-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Sorties / Libérations
                                </div>
                                <div class="bg-white-opacity p-2 rounded-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-logout">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                        <path d="M9 12h12l-3 -3m0 6l3 -3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="lh-1">
                                <div class="display-5 fw-bold mb-2">98</div>
                                <p class="mb-0 small opacity-75">Dossiers clos pour fin de détention</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transferts & Autres motifs --}}
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card card-lg border-0 shadow-sm text-dark"
                        style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                        <div class="card-body d-flex flex-column gap-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold fs-5 text-uppercase tracking-wide opacity-90">Transférés / Radiés</div>
                                <div class="bg-white-opacity p-2 rounded-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-arrows-left-right">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M21 17l-18 0" />
                                        <path d="M6 10l-3 -3l3 -3" />
                                        <path d="M3 7l18 0" />
                                        <path d="M18 20l3 -3l-3 -3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="lh-1">
                                <div class="display-5 fw-bold mb-2">44</div>
                                <p class="mb-0 small opacity-75">Changements d'établissement pénitencier</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Tableau principal du registre des archives --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div
                            class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark">Registre des Détenus Archivés</h5>
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fw-bold">Consultation
                                Seule</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 table-centered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 70px;">Photo</th>
                                        <th>NINA / ID</th>
                                        <th>Nom et Prénom</th>
                                        <th>Infraction & Juridiction</th>
                                        <th>Date Début</th>
                                        <th>Peine Prononcée</th>
                                        <th>Temps Passé</th>
                                        <th>Temps Restant</th>
                                        <th>Sortie Prévue</th>
                                        <th class="text-center" style="width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Ligne Détenu 1 --}}
                                    <tr>
                                        <td>
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 40px; height: 40px; font-size: 12px; background: linear-gradient(135deg, #64748b, #475569)">
                                                KM
                                            </div>
                                        </td>
                                        <td><span class="text-muted fw-mono small">10485923A</span></td>
                                        <td class="fw-semibold text-dark">KEITA Moussa</td>
                                        <td>
                                            <div class="fw-semibold text-dark">Vol Qualifié</div>
                                            <span class="d-block small text-muted">Tribunal de Grande Instance</span>
                                        </td>
                                        <td>12 Jan 2021</td>
                                        <td><span class="fw-semibold text-dark">3 ans</span></td>
                                        <td>3 ans 0 mois</td>
                                        <td><span class="badge bg-dark-subtle text-dark fw-bold">Dossier Clos</span></td>
                                        <td class="fw-bold text-secondary">12 Jan 2024</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-light border"
                                                    title="Voir la fiche complète">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning"
                                                    title="Désarchiver / Restaurer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-refresh">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />
                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Ligne Détenu 2 --}}
                                    <tr>
                                        <td>
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 40px; height: 40px; font-size: 12px; background: linear-gradient(135deg, #ec4899, #db2777)">
                                                AD
                                            </div>
                                        </td>
                                        <td><span class="text-muted fw-mono small">20948311B</span></td>
                                        <td class="fw-semibold text-dark">DIALLO Aminata</td>
                                        <td>
                                            <div class="fw-semibold text-dark">Abus de Confiance</div>
                                            <span class="d-block small text-muted">Cour d'Appel</span>
                                        </td>
                                        <td>05 Mai 2023</td>
                                        <td><span class="fw-semibold text-dark">12 mois</span></td>
                                        <td>12 mois 0 j</td>
                                        <td><span class="badge bg-dark-subtle text-dark fw-bold">Dossier Clos</span></td>
                                        <td class="fw-bold text-secondary">05 Mai 2024</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-light border"
                                                    title="Voir la fiche complète">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning"
                                                    title="Désarchiver / Restaurer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-refresh">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />
                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Ligne Détenu 3 --}}
                                    <tr>
                                        <td>
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 40px; height: 40px; font-size: 12px; background: linear-gradient(135deg, #3b82f6, #1d4ed8)">
                                                SO
                                            </div>
                                        </td>
                                        <td><span class="text-muted fw-mono small">11409573C</span></td>
                                        <td class="fw-semibold text-dark">OUATTARA Souleymane</td>
                                        <td>
                                            <div class="fw-semibold text-dark">Infraction Économique</div>
                                            <span class="d-block small text-muted">Tribunal Spécial</span>
                                        </td>
                                        <td>18 Nov 2022</td>
                                        <td><span class="fw-semibold text-dark">2 ans</span></td>
                                        <td>1 an 4 mois</td>
                                        <td><span class="badge bg-info-subtle text-info fw-bold">Transféré</span></td>
                                        <td class="fw-bold text-secondary">Mars 2024</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-light border"
                                                    title="Voir la fiche complète">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning"
                                                    title="Désarchiver / Restaurer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icon-tabler-refresh">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />
                                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" />
                                                    </svg>
                                                </button>
                                            </div>
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
    </style>

@endsection
