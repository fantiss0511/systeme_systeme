<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infraction extends Model
{
    use HasFactory;

    protected $table = 'infractions';

    protected $primaryKey = 'id_infraction';

    protected $fillable = [
        'type_infraction',
        'nature', 
    ];

    public function condamnations(): HasMany
    {
        return $this->hasMany(Condamnation::class, 'id_infraction', 'id_infraction');
    }
}