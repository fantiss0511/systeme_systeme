<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Condamnation extends Model
{
    use HasFactory;

    protected $table = 'condamnations';
    protected $primaryKey = 'id_condamnation';

    protected $fillable = [
        'matricule_detenu',
        'id_infraction',
        'id_juridiction',
        'date_debut_peine',
        'duree_peine_mois',
        'fin_peine',
    ];

    // Sécurité : Transtypage automatique des dates pour éviter les conflits de chaînes
    protected $casts = [
        'date_debut_peine' => 'date',
        'fin_peine' => 'date',
        'duree_peine_mois' => 'integer', 
    ];

    /**
     * Événement automatique à la sauvegarde d'une condamnation.
     */
    protected static function booted(): void
    {
        static::saving(function (Condamnation $condamnation) {
            if ($condamnation->date_debut_peine && $condamnation->duree_peine_mois) {
                // (int) convertit explicitement la valeur pour rassurer Carbon
                $condamnation->fin_peine = Carbon::parse($condamnation->date_debut_peine)
                    ->addMonths((int)$condamnation->duree_peine_mois);
            }
        });
    }

    /**
     * Relation vers le détenu concerné.
     */
    public function detenu(): BelongsTo
    {
        return $this->belongsTo(Detenu::class, 'matricule_detenu', 'matricule_ou_nina');
    }

    /**
     * Relation vers l'infraction associée.
     */
    public function infraction(): BelongsTo
    {
        return $this->belongsTo(Infraction::class, 'id_infraction');
    }

    /**
     * Relation vers la juridiction associée.
     */
    public function juridiction(): BelongsTo
    {
        return $this->belongsTo(Juridiction::class, 'id_juridiction');
    }
}