<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Detenu extends Model
{
    use HasFactory;

    protected $table = 'detenus';
    protected $primaryKey = 'matricule_ou_nina';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'matricule_ou_nina',
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'photo',
        'statut', 
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    /**
     * Relation avec les condamnations du détenu.
     */
    public function condamnations(): HasMany
    {
        return $this->hasMany(Condamnation::class, 'matricule_detenu', 'matricule_ou_nina');
    }

    /**
     * Récupère la condamnation la plus récente (principale).
     * Modifié : Utilisation d'une relation HasOne/relation fluide pour le Blade
     */
    public function condamnationPrincipale()
    {
        return $this->hasOne(Condamnation::class, 'matricule_detenu', 'matricule_ou_nina')
            ->orderByDesc('fin_peine');
    }

    public function scopePresent(Builder $query): Builder
    {
        return $query->where('statut', 'present');
    }

    public function scopeDecede(Builder $query): Builder
    {
        return $query->where('statut', 'decede');
    }

    /**
     * Recherche multicritère
     */
    public function scopeSearch(Builder $query, ?string $nom, ?string $nina, ?string $dateEntree): Builder
    {
        if ($nom) {
            $query->where(function (Builder $q) use ($nom) {
                $q->where('nom', 'ilike', "%{$nom}%")
                  ->orWhere('prenom', 'ilike', "%{$nom}%");
            });
        }

        if ($nina) {
            $query->where('matricule_ou_nina', $nina);
        }

        if ($dateEntree) {
           $query->whereHas('condamnations', function ($q) use ($dateEntree) {
    $q->whereDate('date_debut_peine', $dateEntree);
});
        }

        return $query;
    }

    /**
     * Filtre les sorties via la table 'condamnations' et sa colonne 'fin_peine'
     */
    public function scopeSortiesPrevuesMois(Builder $query, int $mois, int $annee): Builder
    {
        return $query->present()->whereHas('condamnations', function (Builder $q) use ($mois, $annee) {
            $q->whereMonth('fin_peine', $mois)
              ->whereYear('fin_peine', $annee);
        });
    }
   
}