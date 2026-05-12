<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CompetitionsController extends Controller
{
    /**
     * Liste des compétitions (tableau résultats) avec filtres et recherche.
     */
    public function index(Request $request)
    {
        $q = $request->input('q', $request->input('search'));
        $saison = $request->input('saison');
        $type = $request->input('type');

        $query = Competition::with(['clubDomicile', 'clubAdversaire', 'clubs']);

        if ($saison) {
            $query->where('saison', $saison);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($q && trim((string) $q) !== '') {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], trim((string) $q)) . '%';
            $query->where(function ($sub) use ($like) {
                $sub->where('nom', 'like', $like)
                    ->orWhere('lieu', 'like', $like)
                    ->orWhere('resultat', 'like', $like)
                    ->orWhereHas('clubDomicile', fn ($c) => $c->where('nom', 'like', $like))
                    ->orWhereHas('clubAdversaire', fn ($c) => $c->where('nom', 'like', $like))
                    ->orWhereHas('clubs', fn ($c) => $c->where('nom', 'like', $like));
            });
        }

        $competitions = $query->orderByDesc('date_competition')->paginate(20)->withQueryString();

        $saisons = Competition::query()->select('saison')->whereNotNull('saison')->distinct()->orderByDesc('saison')->pluck('saison');
        $types = Competition::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');

        $typesFilter = collect([
            'Cadets', 'Benjamins', 'Minimes', 'Juniors', 'Séniors', 'Kata',
        ])->merge($types)->unique()->filter()->sort()->values();

        return view('competitions.index', [
            'competitions' => $competitions,
            'saisons' => $saisons,
            'types' => $typesFilter,
            'q' => $q,
            'filterSaison' => $saison,
            'filterType' => $type,
        ]);
    }

    public function show(Competition $competition)
    {
        $competition->load([
            'clubDomicile',
            'clubAdversaire',
            'clubs',
            'judokaResults.joueur.club',
            'galleryImages',
        ]);

        $results = $competition->judokaResults;
        $resultsByCategory = self::sortResultsGroupedByCategory($results);

        $judokaIds = $results->pluck('joueur_id')->unique()->filter();

        $hommes = $results->filter(function ($r) {
            $s = strtoupper(substr((string) ($r->joueur?->sexe ?? ''), 0, 1));

            return in_array($s, ['M', 'H'], true);
        })->pluck('joueur_id')->unique()->count();

        $femmes = $results->filter(function ($r) {
            return strtoupper(substr((string) ($r->joueur?->sexe ?? ''), 0, 1)) === 'F';
        })->pluck('joueur_id')->unique()->count();

        $totalSexe = $hommes + $femmes;
        if ($totalSexe < $judokaIds->count()) {
            $hommes += $judokaIds->count() - $totalSexe;
        }

        $stats = [
            'judokas' => $judokaIds->count(),
            'clubs' => count($competition->participatingClubLabels()),
            'photos' => $competition->galleryImages->count(),
            'hommes' => $hommes,
            'femmes' => $femmes,
        ];

        $medalRanking = [];
        foreach ($results as $r) {
            $clubNom = $r->joueur?->club?->nom ?? '—';
            if (! isset($medalRanking[$clubNom])) {
                $medalRanking[$clubNom] = ['g' => 0, 's' => 0, 'b' => 0, 'pts' => 0];
            }
            match ($r->medal) {
                'gold' => $medalRanking[$clubNom]['g']++,
                'silver' => $medalRanking[$clubNom]['s']++,
                'bronze' => $medalRanking[$clubNom]['b']++,
                default => null,
            };
            $medalRanking[$clubNom]['pts'] = $medalRanking[$clubNom]['g'] * 7 + $medalRanking[$clubNom]['s'] * 3 + $medalRanking[$clubNom]['b'];
        }
        uasort($medalRanking, fn ($a, $b) => $b['pts'] <=> $a['pts']);
        $medalRanking = array_slice($medalRanking, 0, 15, true);

        $qResults = request('q_results');
        $filteredByCategory = $resultsByCategory;
        if ($qResults && trim((string) $qResults) !== '') {
            $needle = mb_strtolower(trim((string) $qResults));
            $filtered = $resultsByCategory->map(function ($group) use ($needle) {
                return $group->filter(function ($r) use ($needle) {
                    $nom = mb_strtolower(trim(($r->joueur?->nom ?? '') . ' ' . ($r->joueur?->prenom ?? '')));
                    $clubNom = mb_strtolower((string) ($r->joueur?->club?->nom ?? ''));

                    return str_contains($nom, $needle)
                        || str_contains($clubNom, $needle)
                        || str_contains(mb_strtolower((string) ($r->categorie_label ?? '')), $needle)
                        || str_contains(mb_strtolower((string) ($r->pays_code ?? '')), $needle);
                });
            })->filter(fn ($g) => $g->isNotEmpty());

            $filteredByCategory = self::reorderFilteredCategories($resultsByCategory, $filtered);
        }

        return view('competitions.show', compact(
            'competition',
            'resultsByCategory',
            'filteredByCategory',
            'stats',
            'medalRanking',
            'qResults'
        ));
    }

    public function resultat($id)
    {
        return redirect()->route('competitions.show', ['competition' => $id], 301);
    }

    /**
     * Groupe par catégorie, trie les rangs dans chaque bloc, ordonne les blocs (poids IJF quand possible).
     *
     * @param  Collection<int, \App\Models\JudokaCompetitionResult>  $results
     * @return Collection<string, Collection<int, \App\Models\JudokaCompetitionResult>>
     */
    private static function sortResultsGroupedByCategory(Collection $results): Collection
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

    /**
     * Conserve l’ordre des catégories du classement complet après filtrage.
     *
     * @param  Collection<string, mixed>  $orderedFull
     * @param  Collection<string, mixed>  $filtered
     * @return Collection<string, mixed>
     */
    private static function reorderFilteredCategories(Collection $orderedFull, Collection $filtered): Collection
    {
        $out = collect();
        foreach ($orderedFull->keys() as $cat) {
            if ($filtered->has($cat) && $filtered->get($cat)->isNotEmpty()) {
                $out->put($cat, $filtered->get($cat));
            }
        }

        return $out;
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
