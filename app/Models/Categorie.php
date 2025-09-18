<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description'
    ];

    // Relation avec les joueurs
    public function joueurs()
    {
        return $this->hasMany(Joueur::class, 'categorie_id');
    }

    // Scope pour recherche
    public function scopeSearch($query, $search)
    {
        return $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }

    // Accesseur pour le nombre de joueurs
    public function getJoueursCountAttribute()
    {
        return $this->joueurs()->count();
    }
}

