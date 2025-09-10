<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commune;
use App\Models\Province;

class CommuneController extends Controller
{
        public function index(Request $request)
    {
        $query = Commune::with(['province']);

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%");
        }

        $communes = $query->withCount('zones')->paginate(15);
        $provinces = Province::all();

        return view('admin.commune.index', compact('communes', 'provinces'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('admin.commune.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ]);

        Commune::create($request->all());

        return redirect()->route('admin.communes.index')
            ->with('success', 'Commune créée avec succès.');
    }

    public function show(Commune $commune)
    {
        $commune->load(['province', 'zones.quartiers']);
        return view('admin.commune.show', compact('commune'));
    }

    public function edit(Commune $commune)
    {
        $provinces = Province::all();
        return view('admin.commune.edit', compact('commune', 'provinces'));
    }

    public function update(Request $request, Commune $commune)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
        ]);

        $commune->update($request->all());

        return redirect()->route('admin.communes.index')
            ->with('success', 'Commune mise à jour avec succès.');
    }

    public function destroy(Commune $commune)
    {
        if ($commune->zones()->count() > 0) {
            return redirect()->route('admin.communes.index')
                ->with('error', 'Impossible de supprimer cette commune car elle contient des zones.');
        }

        $commune->delete();

        return redirect()->route('admin.communes.index')
            ->with('success', 'Commune supprimée avec succès.');
    }
}
