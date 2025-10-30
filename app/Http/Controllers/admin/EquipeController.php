<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipeController extends Controller
{
    public function index()
    {
        $equipes = Equipe::latest()->paginate(15);
        return view('admin.equipe.index', compact('equipes'));
    }

    public function create()
    {
        return view('admin.equipe.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'poste' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('equipes', 'public');
        }

        Equipe::create($validated);

        return redirect()->route('admin.equipes.index')
            ->with('success', 'Membre de l\'équipe ajouté avec succès.');
    }

    public function show(Equipe $equipe)
    {
        return view('admin.equipe.show', compact('equipe'));
    }

    public function edit(Equipe $equipe)
    {
        return view('admin.equipe.edit', compact('equipe'));
    }

    public function update(Request $request, Equipe $equipe)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'poste' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($equipe->photo) {
                Storage::disk('public')->delete($equipe->photo);
            }
            $validated['photo'] = $request->file('photo')->store('equipes', 'public');
        }

        $equipe->update($validated);

        return redirect()->route('admin.equipes.index')
            ->with('success', 'Membre de l\'équipe mis à jour avec succès.');
    }

    public function destroy(Equipe $equipe)
    {
        if ($equipe->photo) {
            Storage::disk('public')->delete($equipe->photo);
        }

        $equipe->delete();

        return redirect()->route('admin.equipes.index')
            ->with('success', 'Membre de l\'équipe supprimé avec succès.');
    }
}