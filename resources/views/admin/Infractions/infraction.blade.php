@extends('admin.layouts.navbar')
@section('title', 'Liste des Infractions')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Liste des Infractions</h3>
        <p class="mb-0 text-secondary">Toutes les infractions enregistrées dans le système</p>
      </div>
      <a href="{{ route('admin.infraction.create') }}" class="btn btn-secondary me-2" style="background-color: #00A76F; border-color: #00A76F;">Nouvelle Infraction</a>
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
              <th>Nature de l'infraction</th>  
              <th class="text-end pe-4">Actions</th> </tr>
          </thead>
          <tbody>
            @if($infractions->isEmpty())
              <tr>
                <td colspan="3" class="text-center text-muted py-4">Aucune infraction enregistrée.</td> </tr>
            @else
              @foreach($infractions as $infraction)
                <tr>
                  <td>{{ $infraction->type_infraction }}</td>
                  <td>{{ $infraction->nature }}</td>
                  <td class="text-end pe-4"> 
                    <form action="{{ route('admin.infraction.destroy', $infraction->id_infraction) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette infraction ?');" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">
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