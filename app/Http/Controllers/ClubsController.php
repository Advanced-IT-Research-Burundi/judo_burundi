<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Competition;
use App\Models\JudokaCompetitionResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClubsController extends Controller
{
    /**
     * Liste des clubs affiliés avec recherche (serveur).
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = Club::query()->orderBy('nom');

        if ($q && trim((string) $q) !== '') {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], trim((string) $q)) . '%';
            $query->where(function ($sub) use ($like) {
                $sub->where('nom', 'like', $like)
                    ->orWhere('description', 'like', $like);
            });
        }

        $clubs = $query->paginate(20)->withQueryString();

        return view('clubs.index', compact('clubs', 'q'));
    }

    /**
     * Vue d’ensemble du club : compétitions auxquelles il participe, effectif judoka.
     */
    public function show(Club $club)
    {
        $club->loadCount('joueurs');

        $competitions = $club->competitionsParticipated()
            ->with(['clubDomicile', 'clubAdversaire', 'clubs'])
            ->take(12)
            ->get();

        $judokas = $club->joueurs()->orderBy('nom')->orderBy('prenom')->take(18)->get();

        $stats = [
            'competitions_count' => $club->competitionsParticipated()->count(),
            'judokas_count' => $club->joueurs_count,
            'gold' => JudokaCompetitionResult::whereHas('joueur', fn ($q) => $q->where('clubs_id', $club->id))->where('medal', 'gold')->count(),
            'silver' => JudokaCompetitionResult::whereHas('joueur', fn ($q) => $q->where('clubs_id', $club->id))->where('medal', 'silver')->count(),
            'bronze' => JudokaCompetitionResult::whereHas('joueur', fn ($q) => $q->where('clubs_id', $club->id))->where('medal', 'bronze')->count(),
        ];

        $latestResults = JudokaCompetitionResult::query()
            ->whereHas('joueur', fn ($q) => $q->where('clubs_id', $club->id))
            ->with(['competition', 'joueur'])
            ->join('competitions', 'competitions.id', '=', 'judoka_competition_results.competition_id')
            ->orderByDesc('competitions.date_competition')
            ->select('judoka_competition_results.*')
            ->take(8)
            ->get();

        return view('clubs.show', compact('club', 'competitions', 'judokas', 'stats', 'latestResults'));
    }

    /**
     * Résultats des compétitions où le club a participé (tous les judokas classement complet),
     * avec icônes / codes clubs. Filtres genre (M/F/tous) et poids façon tableau IJF.
     */
    public function clubResults(Club $club, Request $request)
    {
        $q = $request->input('q');
        $gender = (string) $request->query('gender', 'M');
        if (! in_array($gender, ['all', 'M', 'F'], true)) {
            $gender = 'M';
        }

        $categoryToken = trim((string) $request->query('cat', ''));

        $competitionIds = $club->competitionsParticipated()->pluck('id');

        $competitionsList = Competition::query()
            ->whereIn('id', $competitionIds)
            ->orderByDesc('date_competition')
            ->get();

        $selectedId = (int) $request->input('competition', 0);
        if (! $selectedId || ! $competitionIds->contains($selectedId)) {
            $selectedId = (int) ($competitionsList->first()?->id ?? 0);
        }

        $selectedCompetition = $selectedId ? $competitionsList->firstWhere('id', $selectedId) : null;

        $menWeights = ['-60', '-66', '-73', '-81', '-90', '-100', '+100'];
        $womenWeights = ['-48', '-52', '-57', '-63', '-70', '-78', '+78'];

        $byCategory = collect();
        $categoriesOrdered = collect();

        if ($selectedId) {
            $query = JudokaCompetitionResult::query()
                ->where('competition_id', $selectedId)
                ->with(['joueur.club']);

            $this->applyGenderScope($query, $gender);

            if ($q && trim((string) $q) !== '') {
                $like = '%' . str_replace(['%', '_'], ['\%', '\_'], trim((string) $q)) . '%';
                $query->where(function ($sub) use ($like) {
                    $sub->whereHas('competition', fn ($c) => $c->where('nom', 'like', $like))
                        ->orWhereHas('joueur', fn ($j) => $j->where('nom', 'like', $like)->orWhere('prenom', 'like', $like))
                        ->orWhere('categorie_label', 'like', $like)
                        ->orWhere('pays_code', 'like', $like)
                        ->orWhereHas('joueur.club', fn ($c) => $c->where('nom', 'like', $like));
                });
            }

            /** @var Collection<int, JudokaCompetitionResult> $rows */
            $rows = $query
                ->orderBy('placement')
                ->orderBy('id')
                ->get();

            $byCategory = $rows->groupBy(fn ($r) => trim((string) ($r->categorie_label ?: 'Sans catégorie')));

            $categoriesOrdered = $byCategory->keys()
                ->sort(fn ($a, $b) => $this->compareJudoCategories((string) $a, (string) $b))
                ->values();

            if ($categoryToken !== '') {
                $categoriesOrdered = $categoriesOrdered
                    ->filter(fn ($label) => self::categoryLabelMatchesWeightToken((string) $label, $categoryToken))
                    ->values();
            }
        }

        return view('clubs.results', [
            'club' => $club,
            'q' => $q,
            'genderFilter' => $gender,
            'categoryToken' => $categoryToken,
            'competitionsList' => $competitionsList,
            'selectedCompetition' => $selectedCompetition,
            'selectedCompetitionId' => $selectedId,
            'menWeights' => $menWeights,
            'womenWeights' => $womenWeights,
            'byCategory' => $byCategory,
            'categoriesOrdered' => $categoriesOrdered,
        ]);
    }

    private function applyGenderScope(Builder $query, string $gender): void
    {
        if ($gender === 'M') {
            $query
                ->whereDoesntHave('joueur', function ($jq) {
                    $jq->whereRaw("UPPER(SUBSTRING(TRIM(COALESCE(sexe,'')), 1, 1)) = 'F'");
                })
                ->whereRaw('LOWER(COALESCE(categorie_label, ?)) NOT LIKE ?', ['', '%femme%'])
                ->whereRaw('LOWER(COALESCE(categorie_label, ?)) NOT LIKE ?', ['', '%women%'])
                ->whereRaw('LOWER(COALESCE(categorie_label, ?)) NOT LIKE ?', ['', '%dames%']);

            return;
        }

        if ($gender === 'F') {
            $query->where(function ($w) {
                $w->whereHas('joueur', function ($jq) {
                    $jq->whereRaw("UPPER(SUBSTRING(TRIM(COALESCE(sexe,'')), 1, 1)) = 'F'");
                })
                    ->orWhereRaw('LOWER(COALESCE(categorie_label, ?)) LIKE ?', ['', '%femme%'])
                    ->orWhereRaw('LOWER(COALESCE(categorie_label, ?)) LIKE ?', ['', '%dames%'])
                    ->orWhereRaw('LOWER(COALESCE(categorie_label, ?)) LIKE ?', ['', '%women%']);
            });

            return;
        }
    }

    private static function categoryLabelMatchesWeightToken(string $label, string $token): bool
    {
        $token = trim($token);
        if ($token === '') {
            return true;
        }

        return (bool) preg_match('/' . preg_quote($token, '/') . '/u', $label);
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

    private function compareJudoCategories(string $a, string $b): int
    {
        $ka = self::judoCategorySortKey($a);
        $kb = self::judoCategorySortKey($b);

        if ($ka !== $kb) {
            return $ka <=> $kb;
        }

        return strcmp($a, $b);
    }
}
