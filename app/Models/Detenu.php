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

    
    public function condamnations(): HasMany
    {
        return $this->hasMany(Condamnation::class, 'matricule_detenu', 'matricule_ou_nina');
    }

    
    public function condamnationPrincipale(): ?Condamnation
    {
        return $this->condamnations()
            ->orderByDesc('fin_peine')
            ->first();
    }

    
    
    public function scopePresent(Builder $query): Builder
    {
        return $query->where('statut', 'present');
    }

    
    public function scopeDecede(Builder $query): Builder
    {
        return $query->where('statut', 'decede');
    }

    
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
            $query->whereHas('condamnations', function (Builder $q) use ($dateEntree) {
                $q->whereDate('date_debut_peine', $dateEntree);
            });
        }

        return $query;
    }

    
    public function scopeSortiesPrevuesMois(Builder $query, int $mois, int $annee): Builder
    {
        return $query->present()->whereHas('condamnations', function (Builder $q) use ($mois, $annee) {
            $q->whereYear('fin_peine', $annee)->whereMonth('fin_peine', $mois);
        });
    }
}
