<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    use HasFactory;

    protected $table = 'quartiers';
    protected $guarded = [''];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function joueurs()
    {
        return $this->hasMany(Joueur::class);
    }
}
