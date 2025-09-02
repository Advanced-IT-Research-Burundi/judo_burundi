<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [''];

    public function joueurs()
    {
        return $this->hasMany(Joueur::class);
    }

}
