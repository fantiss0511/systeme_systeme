<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Juridiction extends Model
{
    use HasFactory;

    protected $table = 'juridictions';
    protected $primaryKey = 'id_juridiction';

    protected $fillable = [
        'nom',
        'ville',
        'quartier', 
    ];

    public function condamnations(): HasMany
    {
        return $this->hasMany(Condamnation::class, 'id_juridiction', 'id_juridiction');
    }
}