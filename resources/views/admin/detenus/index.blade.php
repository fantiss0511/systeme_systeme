@extends('admin.layouts.navbar')
@section('title', 'Tableau de Bord - Recensement Pénitencier')
@section('suite')

    <div id="content" class="position-relative h-100">
        <div class="custom-container p-4">

            {{-- Formulaire de Recherche Multicritère --}}
            <div class="card border-0 shadow-sm mb-6">
                <div class="card-body">
                    <h4 class="mb-3 fw-bold text-dark">Recherche Multicritère</h4>
                    <form action="{{ route('admin.search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-semibold">Nom ou Prénom</label>
                                <input type="text" name="nom" class="form-control" placeholder="Ex: Traoré..." value="{{ request('nom') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-semibold">Numéro NINA</label>
                                <input type="text" name="nina" class="form-control" placeholder="Ex: 10239-MALI..." value="{{ request('nina') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-semibold">Date d'Entrée (Incarcération)</label>
                                <input type="date" name="date_entree" class="form-control" value="{{ request('date_entree') }}">
                            </div>
                            <div class="col-12 text-end">
                                <a href="{{ route('admin.detenus.create') }}" class="btn btn-secondary me-2" style="background-color: #00A76F; border-color: #00A76F;">Nouvel Enregistrement</a>
                                <a href="{{ route('admin.search') }}" class="btn btn-secondary me-2">Réinitialiser</a>
                                <button type="submit" class="btn btn-primary" style="background-color: #00A76F; border-color: #00A76F;">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tableau des Résultats --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Résultats du Recensement</h5>
                    <span class="badge bg-primary-subtle text-primary">
                        @if($detenus instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $detenus->total() }} Détenu(s) Trouvé(s)
                        @else
                            {{ $detenus->count() }} Détenu(s) Trouvé(s)
                        @endif
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 table-centered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>NINA</th>
                                <th>Nom et Prénom</th>
                                <th>Infraction & Juridiction</th>
                                <th>Date Début</th>
                                <th>Peine Prononcée</th>
                                <th>Temps Passé</th>
                                <th>Temps Restant</th>
                                <th>Sortie Prévue</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($detenus as $detenu)
                                <tr>
                                    <td>
                                        <img src="{{ $detenu->photo && \Storage::disk('public')->exists($detenu->photo) ? asset('storage/' . $detenu->photo) : asset('assets/images/avatar/avatar-1.jpg') }}" 
                                             alt="Photo {{ $detenu->nom }}" 
                                             class="rounded-circle shadow-sm" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td><span class="fw-mono text-muted">{{ $detenu->nina }}</span></td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $detenu->prenom }} {{ $detenu->nom }}</div>
                                        <div class="small text-secondary">
                                            Né le {{ $detenu->date_naissance ? \Carbon\Carbon::parse($detenu->date_naissance)->format('d/m/Y') : 'Inconnue' }} ({{ $detenu->genre }})
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $detenu->infraction }}</div>
                                        <div class="small text-secondary">{{ $detenu->juridiction }}</div>
                                    </td>
                                    <td>
                                        {{ $detenu->date_entree ? \Carbon\Carbon::parse($detenu->date_entree)->format('d M Y') : '--' }}
                                    </td>
                                    <td>{{ $detenu->peine_annees }} ans</td>
                                    <td><span class="text-success fw-semibold">{{ $detenu->temps_passe }}</span></td>
                                    <td>
                               @if(is_numeric($detenu->temps_restant) || (float)$detenu->temps_restant > 0)
                             <span class="text-danger fw-semibold">{{ round((float)$detenu->temps_restant) }} mois</span>
                             @else
                           <span class="{{ $detenu->temps_restant === 'Libérable' ? 'text-success' : 'text-danger' }} fw-semibold">
                              {{ $detenu->temps_restant }}
                             </span>
                              @endif
                               </td>
                                    <td>
                                        @if($detenu->date_sortie_prevue)
                                            <span class="">{{ \Carbon\Carbon::parse($detenu->date_sortie_prevue)->format('d M Y') }}</span>
                                        @else
                                            <span class="badge bg-secondary">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-ghost btn-icon rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.detenus.show', $detenu) }}">
                                                    <span class="me-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </span>
                                                    <span>Détails</span>
                                                </a>
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.detenus.edit', $detenu) }}">
                                                    <span class="me-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </span>
                                                    <span>Modifier</span>
                                                </a>
                                                <form action="{{ route('admin.detenus.destroy', $detenu) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce détenu ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                                        <span class="me-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </span>
                                                        <span>Supprimer</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">Aucun détenu trouvé correspondant aux critères.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($detenus instanceof \Illuminate\Pagination\LengthAwarePaginator && $detenus->hasPages())
                    <div class="card-footer bg-transparent border-top py-3 d-flex justify-content-center">
                        {{ $detenus->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <style>
        .bg-white-opacity {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .pagination {
            margin-bottom: 0;
        }
    </style>

@endsection