<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quartier;
use App\Models\Zone;

class QuartierController extends Controller
{
       public function index(Request $request)
    {
        $query = Quartier::with(['zone.commune.province']);

        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->zone_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%");
        }

        $quartiers = $query->withCount('joueurs')->paginate(15);
        $zones = Zone::with(['commune.province'])->get();

        return view('admin.quartier.index', compact('quartiers', 'zones'));
    }

    public function create()
    {
        $zones = Zone::with(['commune.province'])->get();
        return view('admin.quartier.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones,id',
        ]);

        Quartier::create($request->all());

        return redirect()->route('admin.quartiers.index')
            ->with('success', 'Quartier créé avec succès.');
    }

    public function show(Quartier $quartier)
    {
        $quartier->load(['zone.commune.province', 'joueurs.categorie']);
        return view('admin.quartier.show', compact('quartier'));
    }

    public function edit(Quartier $quartier)
    {
        $zones = Zone::with(['commune.province'])->get();
        return view('admin.quartier.edit', compact('quartier', 'zones'));
    }

    public function update(Request $request, Quartier $quartier)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $quartier->update($request->all());

        return redirect()->route('admin.quartiers.index')
            ->with('success', 'Quartier mis à jour avec succès.');
    }

    public function destroy(Quartier $quartier)
    {
        if ($quartier->joueurs()->count() > 0) {
            return redirect()->route('admin.quartiers.index')
                ->with('error', 'Impossible de supprimer ce quartier car il contient des joueurs.');
        }

        $quartier->delete();

        return redirect()->route('admin.quartiers.index')
            ->with('success', 'Quartier supprimé avec succès.');
    }

    public function getZonesByCommune(Request $request)
    {
        $zones = Zone::where('commune_id', $request->commune_id)->get();
        return response()->json($zones);
    }

    public function getQuartiersByZone(Request $request)
    {
        $quartiers = Quartier::where('zone_id', $request->zone_id)->get();
        return response()->json($quartiers);
    }
}
