<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Membre extends Model
{
    use HasFactory;

    protected $table = 'membres';
    protected $fillable = [
        'fullname',
        'description',
        'email',
        'telephone',
        'image',
    ];

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

}
