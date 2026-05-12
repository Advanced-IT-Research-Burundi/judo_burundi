<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $table = 'clubs';
    protected $fillable = ['nom', 'description', 'capacite'];

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

    /** Compétitions où le club est inscrit comme participant additionnel. */
    public function competitionsAdditionnelles()
    {
        return $this->belongsToMany(Competition::class, 'club_competition')->withTimestamps();
    }

    /** Toutes les compétitions où ce club apparaît (domicile, adversaire ou pivot). */
    public function competitionsParticipated()
    {
        return Competition::query()
            ->where(function ($q) {
                $q->where('clubdomicil_id', $this->id)
                    ->orWhere('clubadversaire_id', $this->id)
                    ->orWhereHas('clubs', fn ($qq) => $qq->where('clubs.id', $this->id));
            })
            ->orderByDesc('date_competition');
    }

    /** Code court (3 lettres max) pour l’affichage type tableau de classement. */
    public function displayCode(int $length = 3): string
    {
        $nom = trim((string) $this->nom);
        if ($nom === '') {
            return str_repeat('—', max(1, $length));
        }
        $clean = preg_replace('/[^a-zA-ZÀ-ÿ0-9\s]/u', '', $nom);
        $parts = array_values(array_filter(preg_split('/\s+/u', $clean)));
        if ($parts !== []) {
            $letters = '';
            foreach ($parts as $p) {
                $letters .= mb_strtoupper(mb_substr($p, 0, 1));
                if (mb_strlen($letters) >= $length) {
                    break;
                }
            }

            return mb_substr(mb_str_pad($letters, $length, 'X'), 0, $length);
        }

        return mb_strtoupper(mb_substr($nom, 0, $length));
    }

    /** Initiales pour avatar texte lorsqu’aucun logo fichier n’est disponible. */
    public function initialsAvatar(int $max = 2): string
    {
        $parts = preg_split('/\s+/u', trim((string) $this->nom));
        $parts = array_values(array_filter($parts));
        if ($parts === []) {
            return '—';
        }
        $out = mb_strtoupper(mb_substr($parts[0], 0, 1));
        if (isset($parts[1])) {
            $out .= mb_strtoupper(mb_substr($parts[1], 0, 1));
        }

        return mb_substr($out, 0, max(1, $max));
    }
}
