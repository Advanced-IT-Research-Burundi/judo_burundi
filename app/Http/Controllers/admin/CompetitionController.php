<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Club;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::with(['clubDomicile', 'clubAdversaire'])
            ->latest('date_competition')
            ->paginate(15);
        return view('admin.competition.index', compact('competitions'));
    }

    public function create()
    {
        $clubs = Club::all();
        return view('admin.competition.create', compact('clubs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'lieu' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'saison' => 'nullable|string|max:255',
            'date_competition' => 'required|date',
            'resultat' => 'nullable|string|max:255',
            'clubsdomicil_id' => 'required|exists:clubs,id',
            'clubadversaire_id' => 'required|exists:clubs,id|different:clubsdomicil_id',
        ]);

        Competition::create($validated);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition créée avec succès.');
    }

    public function show(Competition $competition)
    {
        $competition->load(['clubDomicile', 'clubAdversaire']);
        return view('admin.competition.show', compact('competition'));
    }

    public function edit(Competition $competition)
    {
        $clubs = Club::all();
        return view('admin.competition.edit', compact('competition', 'clubs'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'lieu' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'saison' => 'nullable|string|max:255',
            'date_competition' => 'required|date',
            'resultat' => 'nullable|string|max:255',
            'clubsdomicil_id' => 'required|exists:clubs,id',
            'clubadversaire_id' => 'required|exists:clubs,id|different:clubsdomicil_id',
        ]);

        $competition->update($validated);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition mise à jour avec succès.');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition supprimée avec succès.');
    }
}