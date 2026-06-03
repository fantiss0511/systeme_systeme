<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    protected $casts = [
        'date_debut_peine' => 'date',
        'fin_peine' => 'date',
    ];

   
    protected static function booted(): void
    {
        static::saving(function (Condamnation $condamnation) {
            if ($condamnation->date_debut_peine && $condamnation->duree_peine_mois) {
                $condamnation->fin_peine = Carbon::parse($condamnation->date_debut_peine)
                    ->addMonths($condamnation->duree_peine_mois);
            }
        });
    }

  
    public function detenu(): BelongsTo
    {
        return $this->belongsTo(Detenu::class, 'matricule_detenu', 'matricule_ou_nina');
    }

  
    public function infraction(): BelongsTo
    {
        return $this->belongsTo(Infraction::class, 'id_infraction', 'id_infraction');
    }

    
    public function juridiction(): BelongsTo
    {
        return $this->belongsTo(Juridiction::class, 'id_juridiction', 'id_juridiction');
    }

   
    public function tempsEcouleJours(): int
    {
        $debut = Carbon::parse($this->date_debut_peine)->startOfDay();
        $fin = min(Carbon::today(), Carbon::parse($this->fin_peine));

        return max(0, (int) $debut->diffInDays($fin));
    }

    
    public function tempsRestantJours(): int
    {
        $reste = Carbon::today()->diffInDays(Carbon::parse($this->fin_peine), false);

        return max(0, (int) $reste);
    }
}
