@extends('admin.layouts.navbar')
@section('title', 'Archiver un Dossier - Recensement Pénitencier')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4" style="padding-top: 5rem !important;">

    <div class="mb-4">
      <a href="{{ route('admin.archive') }}" class="btn btn-sm btn-light border text-muted mb-2"><i class="ti ti-arrow-left"></i> Retour au registre</a>
      <h3 class="fw-bold text-dark">Archiver un Dossier Détenu</h3>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <form action="#" method="POST">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Numéro NINA / ID Détenu</label>
              <input type="text" class="form-control" placeholder="Ex: 10485923A" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Nom Complet</label>
              <input type="text" class="form-control" placeholder="Ex: KEITA Moussa" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Infraction Principale</label>
              <input type="text" class="form-control" placeholder="Ex: Vol Qualifié" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Juridiction Condamnatrice</label>
              <input type="text" class="form-control" placeholder="Ex: Tribunal de Grande Instance" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold text-dark">Date de Début d'Écrou</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold text-dark">Date de Sortie Effective</label>
              <input type="date" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold text-dark">Motif de l'Archivage</label>
              <select class="form-select" required>
                <option value="liberation">Fin de peine / Libération</option>
                <option value="transfert">Transfert d'établissement</option>
                <option value="deces">Décès</option>
              </select>
            </div>
            <div class="col-12 mt-4 text-end">
              <button type="submit" class="btn btn-primary px-4">Valider l'Archivage</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
