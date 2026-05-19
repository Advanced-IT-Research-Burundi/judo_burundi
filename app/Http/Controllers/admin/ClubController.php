<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('joueurs')->latest()->paginate(15);
        return view('admin.club.index', compact('clubs'));
    }

    public function create()
    {
        return view('admin.club.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacite' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = collect($validated)->except('logo')->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('clubs', 'public');
        }

        Club::create($data);

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club créé avec succès.');
    }

    public function show(Club $club)
    {
        $club->load(['joueurs', 'competitionsDomicile', 'competitionsAdversaire']);
        return view('admin.club.show', compact('club'));
    }

    public function edit(Club $club)
    {
        return view('admin.club.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacite' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = collect($validated)->except('logo')->all();

        if ($request->hasFile('logo')) {
            if ($club->logo) {
                Storage::disk('public')->delete($club->logo);
            }
            $data['logo'] = $request->file('logo')->store('clubs', 'public');
        }

        $club->update($data);

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club mis à jour avec succès.');
    }

    public function destroy(Club $club)
    {
        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }

        $club->delete();

        return redirect()->route('admin.clubs.index')
            ->with('success', 'Club supprimé avec succès.');
    }
}