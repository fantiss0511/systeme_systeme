@extends('admin.layouts.navbar')
@section('title', 'Modifier la fiche d\'Écrou')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-12">
        
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-dark">Mise à jour du Dossier Écrou</h4>
            <span class="text-muted small">Matricule / NINA : <strong>{{ $detenu->matricule_ou_nina }}</strong></span>
          </div>
          <div class="card-body">
            
            {{-- Formulaire dynamique connecté à la base de données --}}
           <form action="{{ route('admin.detenus.update', $detenu) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              
              {{-- Affichage des erreurs de validation globales si besoin --}}
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <div class="d-flex align-items-center gap-2 mb-4">
                <h5 class="text-primary mb-0 text-uppercase tracking-wider fs-6">1. Rectification État Civil</h5>
                <hr class="flex-grow-1 my-0">
              </div>

              <div class="row g-4 mb-5">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nom</label>
                  <input type="text" name="nom" class="form-control" value="{{ old('nom', $detenu->nom) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Prénom</label>
                  <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $detenu->prenom) }}" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Numéro NINA / Matricule</label>
                  <input type="text" name="matricule_ou_nina" class="form-control" value="{{ old('matricule_ou_nina', $detenu->matricule_ou_nina) }}" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Date de Naissance</label>
                  <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $detenu->date_naissance) }}" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Sexe</label>
                  <select name="sexe" class="form-select" required>
                    @foreach($genres as $cle => $libelle)
                      <option value="{{ $cle }}" {{ old('sexe', $detenu->sexe) === $cle ? 'selected' : '' }}>
                        {{ $libelle }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- Statut de détention rajouté dynamiquement --}}
                <div class="col-md-12">
                  <label class="form-label fw-semibold">Statut actuel au sein de l'établissement</label>
                  <select name="statut" class="form-select" required>
                    @foreach($statuts as $cle => $libelle)
                      <option value="{{ $cle }}" {{ old('statut', $detenu->statut) === $cle ? 'selected' : '' }}>
                        {{ $libelle }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-12">
                  <label class="form-label fw-semibold">Remplacer la Photo actuelle du détenu</label>
                  <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/jpg">
                  <div class="form-text text-muted">Laissez vide si vous souhaitez conserver la photo actuelle d'enregistrement.</div>
                  
                  @if($detenu->photo)
                    <div class="mt-2">
                      <span class="badge bg-light text-dark border">Photo actuelle enregistrée</span>
                    </div>
                  @endif
                </div>
              </div>

              <div class="d-flex align-items-center gap-2 mb-4">
                <h5 class="text-primary mb-0 text-uppercase tracking-wider fs-6">2. Situation Judiciaire Révisée</h5>
                <hr class="flex-grow-1 my-0">
              </div>

              <div class="row g-4 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nature de l'infraction</label>
                  <input type="text" name="motif_infraction" class="form-control" 
                         value="{{ old('motif_infraction', $condamnation ? DB::table('infractions')->where('id_infraction', $condamnation->id_infraction)->value('nature') : '') }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Juridiction de condamnation</label>
                  <input type="text" name="juridiction" class="form-control" 
                         value="{{ old('juridiction', $condamnation ? DB::table('juridictions')->where('id_juridiction', $condamnation->id_juridiction)->value('nom') : '') }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Date de début de la peine</label>
                  <input type="date" name="date_entree" class="form-control" 
                         value="{{ old('date_entree', $condamnation ? \Carbon\Carbon::parse($condamnation->date_debut_peine)->format('Y-m-d') : '') }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Durée de la peine prononcée (en mois)</label>
                  <input type="number" name="duree_peine_mois" class="form-control" 
                         value="{{ old('duree_peine_mois', $condamnation ? $condamnation->duree_peine_mois : '') }}" min="1" required>
                  <div  style="font-size: 0.875em;" color="green">
                    Toute modification recalculera instantanément la date de sortie théorique.
                    </div>
                </div>
              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light border">Abandonner</a>
                <button type="submit" class="btn btn-success px-4 text-white">Enregistrer les Modifications</button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection