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

    public function competitionResults()
    {
        return $this->hasMany(JudokaCompetitionResult::class, 'joueur_id');
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /** Genre court pour tableaux (H / F). */
    public function genreCourt(): string
    {
        $raw = trim((string) $this->sexe);
        if ($raw === '') {
            return '—';
        }
        $c = strtoupper(mb_substr($raw, 0, 1));
        if (in_array($c, ['M', 'H'], true)) {
            return 'H';
        }
        if ($c === 'F') {
            return 'F';
        }

        return mb_strtoupper(mb_substr($raw, 0, 3));
    }

    /** Poids judoka pour affichage (kg). */
    public function poidsLabel(): string
    {
        if ($this->poids === null || $this->poids === '') {
            return '—';
        }
        $n = (float) $this->poids;
        $formatted = abs($n - round($n)) < 0.001 ? (string) (int) round($n) : number_format($n, 1, ',', '');

        return $formatted . ' kg';
    }
}
