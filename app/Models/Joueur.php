<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;
    
    protected $table = 'joueurs';
    protected $guarded = [''];

    public function quartier()
    {
        return $this->belongsTo(Quartier::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function getFullLocationAttribute()
    {
        return $this->quartier->zone->commune->province->nom . ', ' .
               $this->quartier->zone->commune->nom . ', ' .
               $this->quartier->zone->nom . ', ' .
               $this->quartier->nom;
    }

}
