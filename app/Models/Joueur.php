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
        'nom', 'prenom', 'date_naissance', 'lieu_naissance', 
        'sexe', 'telephone', 'email', 'colline_id', 'categorie_id'
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function colline()
    {
        return $this->belongsTo(Colline::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // NOUVELLE MÉTHODE AJOUTÉE
    public function getInitialesAttribute()
    {
        $prenom = $this->prenom ? substr($this->prenom, 0, 1) : '';
        $nom = $this->nom ? substr($this->nom, 0, 1) : '';
        return strtoupper($prenom . $nom);
    }

    public function getAgeAttribute()
    {
        if (!$this->date_naissance) {
            return null;
        }
        return $this->date_naissance->age;
    }
}