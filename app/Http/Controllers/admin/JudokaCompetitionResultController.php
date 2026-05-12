<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Joueur;
use App\Models\JudokaCompetitionResult;
use Illuminate\Http\Request;

class JudokaCompetitionResultController extends Controller
{
    public function index(Competition $competition)
    {
        $lines = $competition->judokaResults()
            ->with('joueur.club')
            ->orderBy('categorie_label')
            ->orderBy('placement')
            ->get();

        $joueurs = Joueur::with('club')->orderBy('nom')->orderBy('prenom')->get();

        return view('admin.competition.judoka_results', compact('competition', 'lines', 'joueurs'));
    }

    public function store(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'joueur_id' => 'required|exists:joueurs,id',
            'placement' => 'nullable|integer|min:1|max:999',
            'medal' => 'nullable|in:gold,silver,bronze',
            'categorie_label' => 'nullable|string|max:120',
            'pays_code' => 'nullable|string|max:8',
        ]);

        $competition->judokaResults()->create($validated);

        return back()->with('success', 'Résultat judoka enregistré.');
    }

    public function destroy(Competition $competition, JudokaCompetitionResult $result)
    {
        abort_unless((int) $result->competition_id === (int) $competition->id, 404);

        $result->delete();

        return back()->with('success', 'Ligne de résultat supprimée.');
    }
}
