@extends('admin.layouts.navbar')
@section('title', 'Enregistrer un Détenu')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-12">

        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom py-3">
            <h4 class="mb-0 fw-bold text-dark">Formulaire d'Enregistrement Écrou</h4>
          </div>
          <div class="card-body">

            {{-- Pointage dynamique vers la route de stockage --}}
            <form action="{{ route('admin.detenus.store') }}" method="POST" enctype="multipart/form-data">
              @csrf {{-- Protection obligatoire contre les failles CSRF --}}

              <h5 class="text-primary mb-3 text-uppercase tracking-wider fs-6">1. Informations Personnelles</h5>
              <div class="row g-4 mb-5">

                {{-- Nom --}}
                <div class="col-md-6">
                  <label for="nom" class="form-label fw-semibold">Nom</label>
                  <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Entrez le nom de famille" required>
                  @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Prénom --}}
                <div class="col-md-6">
                  <label for="prenom" class="form-label fw-semibold">Prénom</label>
                  <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Entrez le prénom" required>
                  @error('prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Numéro NINA --}}
                <div class="col-md-4">
                  <label for="matricule_ou_nina" class="form-label fw-semibold">Numéro NINA</label>
                  <input type="text" name="matricule_ou_nina" id="matricule_ou_nina" class="form-control @error('matricule_ou_nina') is-invalid @enderror" value="{{ old('matricule_ou_nina') }}" placeholder="Format: X-XXXX-XXXX-X" required>
                  @error('matricule_ou_nina')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Date de Naissance --}}
                <div class="col-md-4">
                  <label for="date_naissance" class="form-label fw-semibold">Date de Naissance</label>
                  <input type="date" name="date_naissance" id="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                  @error('date_naissance')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Sexe --}}
                <div class="col-md-4">
                  <label for="sexe" class="form-label fw-semibold">Sexe</label>
                  <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                    <option value="">Sélectionner...</option>
                    <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                  </select>
                  @error('sexe')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Statuts Matrimoniale --}}
                <div class="col-md-4">
                  <label for="statut_matrimonial" class="form-label fw-semibold">Statut Matrimonial</label>
                  <select name="statut_matrimonial" id="statut_matrimonial" class="form-select @error('statut_matrimonial') is-invalid @enderror" required>
                    <option value="">Sélectionner...</option>
                    <option value="Célibataire" {{ old('statut_matrimonial') === 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié" {{ old('statut_matrimonial') === 'Marié' ? 'selected' : '' }}>Marié</option>
                    <option value="Divorcé" {{ old('statut_matrimonial') === 'Divorcé' ? 'selected' : '' }}>Divorcé</option>
                    <option value="Veuf" {{ old('statut_matrimonial') === 'Veuf' ? 'selected' : '' }}>Veuf</option>
                  </select>
                  @error('statut_matrimonial')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Photo d'identité --}}
                <div class="col-12">
                  <label for="photo" class="form-label fw-semibold">Photo d'identité du Détenu</label>
                  <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                  <div class="form-text">Format accepté : JPG, PNG. Taille max : 2 Mo.</div>
                  @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <h5 class="text-primary mb-3 text-uppercase tracking-wider fs-6">2. Informations Judiciaires & Condamnation</h5>
              <div class="row g-4 mb-4">

                {{-- Sélection du Type et de la Nature de l'Infraction --}}
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="select_type_infraction" class="form-label fw-semibold">Type d'infraction :</label>
                    <select id="select_type_infraction" class="form-control" required>
                      <option value="">-- Sélectionner un type --</option>
                      <option value="Délit">Délit</option>
                      <option value="Crime">Crime</option>
                      <option value="Contravention">Contravention</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_infraction" class="form-label fw-semibold">Infraction commise (Nature) :</label>
                    <select name="id_infraction" id="id_infraction" class="form-control @error('id_infraction') is-invalid @enderror" required disabled>
                      <option value="">-- Sélectionnez d'abord un type --</option>
                      @foreach($infractions as $infraction)
                        <option value="{{ $infraction->id_infraction }}" data-type="{{ $infraction->type_infraction }}">
                          {{ $infraction->nature }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_infraction')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- Juridiction --}}
                <div class="col-12">
                  <label for="id_juridiction" class="form-label fw-semibold">Juridiction :</label>
                  <select name="id_juridiction" id="id_juridiction" class="form-control @error('id_juridiction') is-invalid @enderror" required>
                    <option value="">-- Sélectionner une juridiction --</option>
                    @foreach($juridictions as $juridiction)
                      <option value="{{ $juridiction->id_juridiction }}" {{ old('id_juridiction') == $juridiction->id_juridiction ? 'selected' : '' }}>
                        {{ $juridiction->nom }} ({{ $juridiction->ville }})
                      </option>
                    @endforeach
                  </select>
                  @error('id_juridiction')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Date de début de peine --}}
                <div class="col-md-6">
                  <label for="date_entree" class="form-label fw-semibold">Date de début de la peine</label>
                  <input type="date" name="date_entree" id="date_entree" class="form-control @error('date_entree') is-invalid @enderror" value="{{ old('date_entree') }}" required>
                  @error('date_entree')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Durée de la peine --}}
                <div class="col-md-6">
                  <label for="duree_peine_mois" class="form-label fw-semibold">Durée de la peine prononcée (en mois)</label>
                  <input type="number" name="duree_peine_mois" id="duree_peine_mois" class="form-control @error('duree_peine_mois') is-invalid @enderror" value="{{ old('duree_peine_mois') }}" placeholder="Ex: 24" min="1" required>
                  <div class="form-text text-success" style="font-size: 0.785em;">
                    La date de sortie prévue sera calculée automatiquement par le système.
                  </div>
                  @error('duree_peine_mois')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <hr class="my-4">
              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light border">Annuler</a>
                <button type="submit" class="btn btn-primary px-4" style="background-color: #00A76F;">Valider l'Incarcération</button>
              </div>
              
</div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

{{-- Script de filtrage dynamique des infractions par type --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('select_type_infraction');
    const natureSelect = document.getElementById('id_infraction');

    
    const originalOptions = Array.from(natureSelect.options)
        .filter(function (opt) { return opt.value !== ''; })
        .map(function (opt) { return opt.cloneNode(true); });

    typeSelect.addEventListener('change', function () {
        const selectedType = this.value;

  
        natureSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';

        if (!selectedType) {
            placeholder.text = "-- Sélectionnez d'abord un type --";
            natureSelect.appendChild(placeholder);
            natureSelect.disabled = true;
            return;
        }

        const filteredOptions = originalOptions.filter(function (option) {
            return option.getAttribute('data-type') === selectedType;
        });

        if (filteredOptions.length === 0) {
            placeholder.text = 'Aucune nature enregistrée pour ce type';
            natureSelect.appendChild(placeholder);
            natureSelect.disabled = true;
        } else {
            placeholder.text = "-- Choisir la nature du " + selectedType + " --";
            natureSelect.appendChild(placeholder);

            filteredOptions.forEach(function (option) {
                natureSelect.appendChild(option.cloneNode(true));
            });

            natureSelect.disabled = false;
        }
    });
});
</script>

@endsection