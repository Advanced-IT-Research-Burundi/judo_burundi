<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
    ];

    // Relations
    public function joueurs()
    {
        return $this->hasMany(Joueur::class, 'categorie_id');
    }

    // Accessors
    public function getNombreJoueursAttribute()
    {
        return $this->joueurs()->count();
    }

    // Scopes
    public function scopeWithJoueursCount($query)
    {
        return $query->withCount('joueurs');
    }
}

