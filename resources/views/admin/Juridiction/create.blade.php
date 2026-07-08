@extends('admin.layouts.navbar')
@section('title', 'Enregistrer une juridiction')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-12">
        
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom py-3">
            <h4 class="mb-0 fw-bold text-dark">Formulaire d'Enregistrement d'une Juridiction</h4>
          </div>
          <div class="card-body">
            
            {{-- Pointage dynamique vers la route de stockage --}}
            <form action="{{ route('admin.juridiction.store') }}" method="POST" enctype="multipart/form-data">
              @csrf {{-- Protection obligatoire contre les failles CSRF --}}
              
              <div class="row g-4 mb-5">
                
                <div class="col-md-6">
                  <label for="nom" class="form-label fw-semibold">Nom Juridiction</label>
                  <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Entrez le nom de la juridiction" required>
                  @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="col-md-6">
                  <label for="ville" class="form-label fw-semibold">Ville</label>
                  <input type="text" name="ville" id="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}" placeholder="Entrez la ville" required>
                  @error('ville')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="col-md-6">
                  <label for="quartier" class="form-label fw-semibold">Quartier</label>
                  <input type="text" name="quartier" id="quartier" class="form-control @error('quartier') is-invalid @enderror" value="{{ old('quartier') }}" placeholder="Entrez le quartier" required>
                  @error('quartier')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>   
              </div>

              <hr class="my-4">
              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.juridiction.index') }}" class="btn btn-light border">Annuler</a>
                <button type="submit" class="btn btn-primary px-4" style="background-color: #00A76F; border-color: #00A76F;">Enregistrer</button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection