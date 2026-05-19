<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    /**
     * Résultats groupés par libellé de catégorie (ex. Hommes -60 kg), blocs triés comme sur la fiche compétition.
     *
     * @return Collection<string, Collection<int, JudokaCompetitionResult>>
     */
    public function judokaResultsGroupedByCategory(): Collection
    {
        $results = $this->relationLoaded('judokaResults')
            ? $this->judokaResults
            : $this->judokaResults()->with(['joueur.club'])->get();

        return self::sortResultsGroupedByCategoryStatic(collect($results->all()));
    }

    /**
     * Une entrée par judoka participant : fusionne les lignes multi-catégories en gardant le meilleur classement.
     *
     * @return Collection<int, JudokaCompetitionResult>
     */
    public function uniqueJudokaResultsByJoueur(): Collection
    {
        $results = $this->relationLoaded('judokaResults')
            ? $this->judokaResults
            : $this->judokaResults()->with(['joueur.club'])->get();

        return $results
            ->filter(fn ($r) => $r->joueur_id !== null)
            ->groupBy('joueur_id')
            ->map(function (Collection $lines) {
                return $lines->sort(function (JudokaCompetitionResult $a, JudokaCompetitionResult $b) {
                    $pa = (int) ($a->placement ?? 9999);
                    $pb = (int) ($b->placement ?? 9999);
                    if ($pa !== $pb) {
                        return $pa <=> $pb;
                    }
                    $medalCmp = self::medalPriority($a->medal) <=> self::medalPriority($b->medal);
                    if ($medalCmp !== 0) {
                        return $medalCmp;
                    }

                    return $a->id <=> $b->id;
                })->first();
            })
            ->values()
            ->sort(function (JudokaCompetitionResult $a, JudokaCompetitionResult $b) {
                $pa = (int) ($a->placement ?? 9999);
                $pb = (int) ($b->placement ?? 9999);
                if ($pa !== $pb) {
                    return $pa <=> $pb;
                }

                return strcmp(
                    mb_strtoupper((string) ($a->joueur?->nom ?? '')),
                    mb_strtoupper((string) ($b->joueur?->nom ?? ''))
                );
            })
            ->values();
    }

    private static function medalPriority(?string $medal): int
    {
        return match ($medal) {
            'gold' => 0,
            'silver' => 1,
            'bronze' => 2,
            default => 9,
        };
    }

    /**
     * @param  Collection<int, JudokaCompetitionResult>  $results
     * @return Collection<string, Collection<int, JudokaCompetitionResult>>
     */
    private static function sortResultsGroupedByCategoryStatic(Collection $results): Collection
    {
        $grouped = $results
            ->groupBy(fn ($r) => trim((string) ($r->categorie_label ?: 'Toutes catégories')))
            ->map(function ($lines) {
                return $lines
                    ->sortBy(fn ($r) => [(int) ($r->placement ?? 9999), $r->id])
                    ->values();
            });

        $keys = $grouped->keys()->sort(fn ($a, $b) => self::compareJudoCategoryLabels((string) $a, (string) $b))->values();

        return $keys->mapWithKeys(fn ($k) => [$k => $grouped->get($k)]);
    }

    private static function judoCategorySortKey(string $label): int
    {
        if (preg_match('/\+\s*(\d+)/u', $label, $m)) {
            return 1000 + (int) $m[1];
        }

        if (preg_match('/-\s*(\d+)/u', $label, $m)) {
            return (int) $m[1];
        }

        return 5000 + (crc32($label) % 1000);
    }

    private static function compareJudoCategoryLabels(string $a, string $b): int
    {
        $ka = self::judoCategorySortKey($a);
        $kb = self::judoCategorySortKey($b);

        if ($ka !== $kb) {
            return $ka <=> $kb;
        }

        return strcmp($a, $b);
    }
}
