<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Categorie::withCount('joueurs');

            if ($request->filled('search')) {
                $query->search($request->search);
            }

            $categories = $query->orderBy('nom')->paginate(15);

            return view('admin.categories.index', compact('categories'));

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des catégories: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du chargement des catégories.');
        }
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:categories,nom',
                'description' => 'nullable|string'
            ]);

            Categorie::create($validatedData);

            return redirect()->route('admin.categories.index')
                           ->with('success', 'Catégorie créée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la catégorie: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création de la catégorie.');
        }
    }

    public function show(Categorie $categorie)
    {
        try {
            $categorie->load('joueurs.colline');
            return view('admin.categories.show', compact('categorie'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage de la catégorie: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')->with('error', 'Catégorie introuvable.');
        }
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
                'description' => 'nullable|string'
            ]);

            $categorie->update($validatedData);

            return redirect()->route('admin.categories.index')
                           ->with('success', 'Catégorie mise à jour avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la catégorie: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la mise à jour de la catégorie.');
        }
    }

    public function destroy(Categorie $categorie)
    {
        try {
            if ($categorie->joueurs()->count() > 0) {
                return redirect()->route('admin.categories.index')
                               ->with('error', 'Impossible de supprimer cette catégorie car elle contient des joueurs.');
            }

            $categorie->delete();

            return redirect()->route('admin.categories.index')
                           ->with('success', 'Catégorie supprimée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la catégorie: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')
                           ->with('error', 'Erreur lors de la suppression de la catégorie.');
        }
    }
}