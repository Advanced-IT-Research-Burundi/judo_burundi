<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Club;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Competition::with(['clubDomicile', 'clubAdversaire', 'clubs'])
            ->latest('date_competition');

        if ($search = $request->query('search')) {
            $like = '%' . $search . '%';

            $query->where(function ($query) use ($like) {
                $query->where('nom', 'like', $like)
                    ->orWhere('lieu', 'like', $like)
                    ->orWhere('type', 'like', $like)
                    ->orWhere('saison', 'like', $like)
                    ->orWhereHas('clubDomicile', fn ($q) => $q->where('nom', 'like', $like))
                    ->orWhereHas('clubAdversaire', fn ($q) => $q->where('nom', 'like', $like))
                    ->orWhereHas('clubs', fn ($q) => $q->where('nom', 'like', $like));
            });
        }

        $competitions = $query->paginate(15)->withQueryString();

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
            'resultat' => 'required|string',
            'clubdomicil_id' => 'required|exists:clubs,id',
            'clubadversaire_id' => 'required|exists:clubs,id|different:clubdomicil_id',
            'club_ids' => 'nullable|array',
            'club_ids.*' => 'exists:clubs,id',
        ]);

        $competition = Competition::create($validated);
        $this->syncExtraClubs($request, $competition);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition créée avec succès.');
    }

    public function show(Competition $competition)
    {
        $competition->load(['clubDomicile', 'clubAdversaire', 'clubs']);
        return view('admin.competition.show', compact('competition'));
    }

    public function edit(Competition $competition)
    {
        $clubs = Club::all();
        $competition->load('clubs');
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
            'clubdomicil_id' => 'required|exists:clubs,id',
            'clubadversaire_id' => 'required|exists:clubs,id|different:clubdomicil_id',
            'club_ids' => 'nullable|array',
            'club_ids.*' => 'exists:clubs,id',
        ]);

        $competition->update($validated);
        $this->syncExtraClubs($request, $competition);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition mise à jour avec succès.');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Compétition supprimée avec succès.');
    }

    /** @param  \Illuminate\Http\Request  $request */
    private function syncExtraClubs(Request $request, Competition $competition): void
    {
        $ids = collect($request->input('club_ids', []))->map(fn ($id) => (int) $id)->filter()->unique()->values();
        $exclude = array_filter([(int) $competition->clubdomicil_id, (int) $competition->clubadversaire_id]);
        $ids = $ids->reject(fn (int $id) => in_array($id, $exclude, true))->values();

        $competition->clubs()->sync($ids->all());
    }
}
