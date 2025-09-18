<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'categorie_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // Relations
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function colline()
    {
        return $this->belongsTo(Colline::class, 'colline_id');
    }

    // Accessors
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getAgeAttribute()
    {
        if (!$this->date_naissance) {
            return null;
        }
        return Carbon::parse($this->date_naissance)->age;
    }

    // Scopes
    public function scopeByCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    public function scopeByColline($query, $collineId)
    {
        return $query->where('colline_id', $collineId);
    }

    public function scopeBySexe($query, $sexe)
    {
        return $query->where('sexe', $sexe);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('telephone', 'like', "%{$search}%");
        });
    }
}
