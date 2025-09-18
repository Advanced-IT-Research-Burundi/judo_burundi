<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategorieRequest; 

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('joueurs')
            ->latest()
            ->paginate(15);

        return view('admin.categorie.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categorie.create');
    }

    public function store(CategorieRequest $request)
    {
        $categorie = Categorie::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(Categorie $categorie)
    {
        $categorie->load(['joueurs' => function ($query) {
            $query->latest();
        }]);

        return view('admin.categorie.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categorie.edit', compact('categorie'));
    }

    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $categorie->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->joueurs()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des joueurs.');
        }

        $categorie->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}