@extends('admin.layouts.navbar')
@section('title', "Types d'Infractions")
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Types d'Infractions</h3>
        <p class="mb-0 text-secondary">Tous les types d'infractions enregistrés dans le système</p>
      </div>
      <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#addInfractionModal" style="background-color: #00A76F; border-color: #00A76F;">
        Nouveau Type d'Infraction
      </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 table-centered table-hover">
          <thead class="table-light">
            <tr>
              <th>Type Infraction</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($infractions as $infraction)
                <tr>
                  <td><span class="badge bg-light text-dark border">{{ $infraction->type_infraction }}</span></td>
                  <td class="text-end pe-4">
                    <form action="{{ route('admin.infraction.destroy', $infraction->id_infraction) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type d\'infraction ?');" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i> Supprimer
                      </button>
                    </form>
                  </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center text-muted py-4">Aucun type d'infraction enregistré.</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="addInfractionModal" tabindex="-1" aria-labelledby="addInfractionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addInfractionModalLabel">Enregistrer un Type d'Infraction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.infraction.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="type_infraction" class="form-label">Type d'infraction</label>
                <input type="text" name="type_infraction" id="type_infraction" class="form-control @error('type_infraction') is-invalid @enderror" value="{{ old('type_infraction') }}" placeholder="Ex: Crime, Délit, Contravention..." required>
                @error('type_infraction')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary" style="background-color: #00A76F; border-color: #00A76F;">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection