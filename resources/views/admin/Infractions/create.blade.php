@extends('admin.layouts.navbar')
@section('title', 'Enregistrer une Infraction')
@section('suite')

<div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.infraction.store') }}" method="POST">

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-12">
        
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom py-3">
            <h4 class="mb-0 fw-bold text-dark">Formulaire d'Enregistrement d'une Infraction</h4>
          </div>
          <div class="card-body">
            
            {{-- Pointage dynamique vers la route de stockage --}}
            <form action="{{ route('admin.infraction.store') }}" method="POST">
              @csrf {{-- Protection obligatoire contre les failles CSRF --}}
              
              <div class="row g-4 mb-5">
                
                <div class="col-md-6">
                  <label for="type_infraction" class="form-label fw-semibold">Type d'Infraction</label>
                  <input type="text" name="type_infraction" id="type_infraction" class="form-control @error('type_infraction') is-invalid @enderror" value="{{ old('type_infraction') }}" placeholder="Ex: Délit, Crime, Contravention" required>
                  @error('type_infraction')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
                <div class="col-md-6">
                  <label for="nature" class="form-label fw-semibold">Nature de l'Infraction</label>
                  <input type="text" name="nature" id="nature" class="form-control @error('nature') is-invalid @enderror" value="{{ old('nature') }}" placeholder="Ex: Vol qualifié, Escroquerie" required>
                  @error('nature')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                
              </div>
                
              <hr class="my-4">
              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.infraction.index') }}" class="btn btn-light border">Annuler</a>
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