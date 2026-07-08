@extends('admin.layouts.navbar')
@section('title', 'Liste des Juridictions')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Liste des Juridictions</h3>
        <p class="mb-0 text-secondary">Toutes les juridictions enregistrées dans le système</p>
      </div>
      <a href="{{ route('admin.juridiction.create') }}" class="btn btn-secondary me-2" style="background-color: #00A76F; border-color: #00A76F;">Nouvelle Juridiction</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 table-centered table-hover">
          <thead class="table-light">
            <tr>
              <th>Nom Juridiction</th>
              <th>Quartier</th>
              <th>Ville</th>
              <th class="text-center">Actions</th> </tr>
          </thead>
          <tbody>
            @if($juridictions->isEmpty())
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Aucune juridiction enregistrée.</td>
              </tr>
            @else
              @foreach($juridictions as $juridiction)
                <tr>
                  <td>{{ $juridiction->nom }}</td>
                  <td>{{ $juridiction->quartier }}</td>
                  <td>{{ $juridiction->ville }}</td>
                  <td class="text-center">
                    <form action="{{ route('admin.juridiction.destroy', $juridiction->id_juridiction) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette juridiction ?');" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
                        <i class="bi bi-trash"></i> Supprimer
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection