<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;

    protected $table = 'joueurs';

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'telephone',
        'email',
        'colline_id',
        'categorie_id'
    ];

    protected $casts = [
        'date_naissance' => 'date'
    ];

    // Relations
    public function colline()
    {
        return $this->belongsTo(Colline::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getAgeAttribute()
    {
        if (!$this->date_naissance) {
            return null;
        }
        return $this->date_naissance->age;
    }

    // Scopes
    public function scopeParCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    public function scopeParColline($query, $collineId)
    {
        return $query->where('colline_id', $collineId);
    }

    public function scopeParSexe($query, $sexe)
    {
        return $query->where('sexe', $sexe);
    }
}