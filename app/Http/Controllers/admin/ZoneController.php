<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Commune;


class ZoneController extends Controller
{
        public function index(Request $request)
    {
        $query = Zone::with(['commune.province']);

        if ($request->filled('commune_id')) {
            $query->where('commune_id', $request->commune_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%");
        }

        $zones = $query->withCount('quartiers')->paginate(15);
        $communes = Commune::with('province')->get();

        return view('admin.zone.index', compact('zones', 'communes'));
    }

    public function create()
    {
        $communes = Commune::with('province')->get();
        return view('admin.zone.create', compact('communes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'commune_id' => 'required|exists:communes,id',
        ]);

        Zone::create($request->all());

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone créée avec succès.');
    }

    public function show(Zone $zone)
    {
        $zone->load(['commune.province', 'quartiers.joueurs']);
        return view('admin.zone.show', compact('zone'));
    }

    public function edit(Zone $zone)
    {
        $communes = Commune::with('province')->get();
        return view('admin.zone.edit', compact('zone', 'communes'));
    }

    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'commune_id' => 'required|exists:communes,id',
        ]);

        $zone->update($request->all());

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone mise à jour avec succès.');
    }

    public function destroy(Zone $zone)
    {
        if ($zone->quartiers()->count() > 0) {
            return redirect()->route('admin.zones.index')
                ->with('error', 'Impossible de supprimer cette zone car elle contient des quartiers.');
        }

        $zone->delete();

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone supprimée avec succès.');
    }
}
