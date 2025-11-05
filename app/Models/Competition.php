<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
    protected $table = 'competitions';
    protected $fillable = [
        'nom',
        'lieu',
        'type',
        'description',
        'saison',
        'date_competition',
        'resultat',
        'clubdomicil_id',
        'clubadversaire_id',
    ];

    protected $casts = [
        'date_competition' => 'datetime',
    ];

    public function clubDomicile()
    {
        return $this->belongsTo(Club::class, 'clubdomicil_id');
    }

    public function clubAdversaire()
    {
        return $this->belongsTo(Club::class, 'clubadversaire_id');
    }
}
