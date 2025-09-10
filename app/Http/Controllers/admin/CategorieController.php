<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('joueurs')->paginate(10);
        return view('admin.categorie.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categorie.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ]);

        Categorie::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(Categorie $categorie)
    {
        $categorie->load(['joueurs.quartier.zone.commune']);
        return view('admin.categorie.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categorie.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string'
        ]);

        $categorie->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->joueurs()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des joueurs.');
        }

        $categorie->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
