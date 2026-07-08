@extends('admin.layouts.navbar')
@section('title', 'Registre des Décès')
@section('suite')

<div id="content" class="position-relative h-100">
  <div class="custom-container p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Registre des Décès Constatés</h3>
        <p class="mb-0 text-secondary">Archive des coupures de peine pour motif de décès (Établissement : {{ ($typePrison ?? 'homme') === 'femme' ? 'Femmes' : 'Hommes' }})</p>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table text-nowrap mb-0 table-centered table-hover">
          <thead class="table-light">
            <tr>
              <th>ID Écrou / NINA</th>
              <th>Nom & Prénom</th>
              <th>Sexe</th>
              <th>Infraction commise</th>
              <th>Date de Décès / Clôture</th>
              <th>Statut Dossier</th>
            </tr>
          </thead>
          <tbody>
            @forelse($detenusDecedes ?? [] as $detenu)
              @php
                // Récupération de la condamnation associée via la propriété magique
                $condamnation = $detenu->condamnationPrincipale;
              @endphp
              <tr>
                <td><span class="fw-mono text-muted">{{ $detenu->matricule_ou_nina }}</span></td>
                <td class="fw-bold text-dark">{{ Str::upper($detenu->nom) }} {{ Str::headline($detenu->prenom) }}</td>
                <td>{{ $detenu->sexe === 'M' ? 'Masculin' : 'Féminin' }}</td>
                <td>
                  {{-- Correction ici : On va chercher la propriété texte de l'infraction (ex: ->libelle) --}}
                  @if($detenu->infraction)
                    {{ $detenu->infraction }}
                  @elseif($condamnation && $condamnation->infraction)
                    {{ $condamnation->infraction->libelle }} 
                  @else
                    Non spécifiée
                  @endif
                </td>
                <td>
                  {{-- Utilisation de updated_at comme repère de l'enregistrement du décès --}}
                  @if($detenu->updated_at)
                    {{ \Carbon\Carbon::parse($detenu->updated_at)->translatedFormat('d M Y') }}
                  @else
                    -
                  @endif
                </td>
                <td>
                  <span class="badge bg-success-subtle text-success fw-bold">Transmis au Parquet</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Aucun décès enregistré dans ce registre.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection