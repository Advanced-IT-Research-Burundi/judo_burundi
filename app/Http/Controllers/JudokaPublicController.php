<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\GalleryImage;
use App\Models\Joueur;
use Illuminate\Http\Request;

class JudokaPublicController extends Controller
{
    /**
     * Fiche judoka (profil type « référence internationale ») dans le contexte du club.
     */
    public function show(Club $club, Joueur $joueur, Request $request)
    {
        abort_unless((int) $joueur->clubs_id === (int) $club->id, 404);

        $joueur->load(['club']);
        $results = $joueur->competitionResults()
            ->with('competition')
            ->get()
            ->sortByDesc(fn ($r) => optional($r->competition?->date_competition)?->timestamp ?? 0)
            ->values();

        $competitionIds = $results->pluck('competition_id')->unique()->filter();

        $photos = GalleryImage::query()
            ->whereIn('competition_id', $competitionIds)
            ->latest()
            ->take(24)
            ->get();

        $medals = [
            'gold' => $results->where('medal', 'gold')->count(),
            'silver' => $results->where('medal', 'silver')->count(),
            'bronze' => $results->where('medal', 'bronze')->count(),
            'other' => $results->whereNull('medal')->whereNotNull('placement')->count(),
        ];

        $qPhoto = $request->input('q_photo');
        $photosFiltered = $photos;
        if ($qPhoto && trim((string) $qPhoto) !== '') {
            $needle = mb_strtolower(trim((string) $qPhoto));
            $photosFiltered = $photos->filter(function ($img) use ($needle) {
                return str_contains(mb_strtolower((string) ($img->titre ?? '')), $needle);
            })->values();
        }

        return view('judokas.show', compact('club', 'joueur', 'results', 'photos', 'photosFiltered', 'medals', 'qPhoto'));
    }
}
