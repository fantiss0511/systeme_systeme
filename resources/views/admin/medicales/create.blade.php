@extends('admin.layouts.navbar')
@section('title', 'Nouvelle Extraction Médicale')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4" style="padding-top: 5rem !important;">

    <div class="mb-4">
      <a href="{{ route('admin.medicale') }}" class="btn btn-sm btn-light border text-muted mb-2"><i class="ti ti-arrow-left"></i> Retour au suivi</a>
      <h3 class="fw-bold text-dark">Créer un Ordre d'Extraction Médicale</h3>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <form action="#" method="POST">
          <div class="row g-4">
            <div class="col-md-4">
              <label class="form-label fw-semibold text-dark">Type de Sortie</label>
              <select class="form-select border-danger text-danger fw-bold" id="type_urgence">
                <option value="rdv">Rendez-vous Hospitalier Programmé</option>
                <option value="urgence">URGENCE MÉDICALE CRITIQUE</option>
              </select>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold text-dark">Sélectionner le Détenu Présent</label>
              <input type="text" class="form-control" placeholder="Rechercher par NINA ou Nom du détenu..." required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Hôpital / Établissement de Santé Cible</label>
              <input type="text" class="form-control" placeholder="Ex: CHU Point G / Hôpital Gabriel Touré" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Escorte / Garde Pénitentiaire Requise</label>
              <input type="text" class="form-control" placeholder="Ex: Brigade d'escorte Alpha (3 agents)" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Date et Heure de Départ Prévues</label>
              <input type="datetime-local" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold text-dark">Date de Retour Prévue</label>
              <input type="datetime-local" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold text-dark">Observations / Pathologie (Optionnel)</label>
              <textarea class="form-control" rows="3" placeholder="Informations complémentaires utiles pour les équipes de santé..."></textarea>
            </div>
            <div class="col-12 mt-4 d-flex justify-content-between">
              <span class="text-muted small align-self-center"><i class="ti ti-info-circle"></i> Ce bon génère automatiquement un document d'autorisation d'extraction.</span>
              <button type="submit" class="btn btn-danger px-4">Émettre le Bon d'Extraction</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
