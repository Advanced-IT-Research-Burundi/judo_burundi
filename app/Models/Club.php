<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $table = 'clubs';
    protected $fillable = ['nom', 'lieu', 'type', 'description', 'saison', 'date_competition', 'resultat', 'clubdomicil_id', 'clubadversaire_id'];

    public function joueurs()
    {
        return $this->hasMany(Joueur::class, 'clubs_id');
    }

    public function competitionsDomicile()
    {
        return $this->hasMany(Competition::class, 'clubdomicil_id');
    }

    public function competitionsAdversaire()
    {
        return $this->hasMany(Competition::class, 'clubadversaire_id');
    }

}
