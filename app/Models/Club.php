<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $table = 'clubs';
    protected $guarded = [];

    public function joueurs()
    {
        return $this->hasMany(Joueur::class, 'clubs_id');
    }

    public function competitionsDomicile()
    {
        return $this->hasMany(Competition::class, 'clubsdomicil_id');
    }

    public function competitionsAdversaire()
    {
        return $this->hasMany(Competition::class, 'clubadversaire_id');
    }

}
