<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joueur extends Model
{
    use HasFactory;
    protected $table = 'joueurs';
    protected $guarded = [];

    public function club()
    {
        return $this->belongsTo(Club::class, 'clubs_id');
    }
        public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}
