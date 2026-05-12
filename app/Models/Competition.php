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

    /** Clubs additionnels inscrits via la table pivot (hors domicile / adversaire). */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_competition')->withTimestamps();
    }

    /**
     * Noms distincts des clubs participants (domicile, adversaire, pivot).
     *
     * @return list<string>
     */
    public function participatingClubLabels(): array
    {
        $names = collect();
        if ($this->clubDomicile) {
            $names->push($this->clubDomicile->nom);
        }
        if ($this->clubAdversaire) {
            $names->push($this->clubAdversaire->nom);
        }
        foreach ($this->clubs as $c) {
            $names->push($c->nom);
        }

        return $names->filter()->map(fn ($n) => trim((string) $n))->unique()->values()->all();
    }

    public function participatingClubsShort(): string
    {
        return implode(', ', $this->participatingClubLabels());
    }

    public function judokaResults()
    {
        return $this->hasMany(JudokaCompetitionResult::class)
            ->orderByRaw('CASE WHEN placement IS NULL THEN 1 ELSE 0 END')
            ->orderBy('placement')
            ->orderBy('id');
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
