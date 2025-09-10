<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Colline;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JoueurController extends Controller
{
    public function index(Request $request)
    {
        $query = Joueur::with(['colline', 'categorie']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('colline_id')) {
            $query->where('colline_id', $request->colline_id);
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }

        $joueurs = $query->orderBy('nom')->orderBy('prenom')->paginate(20);

        $collines = Colline::orderBy('name')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.joueur.index', compact('joueurs', 'collines', 'categories'));
    }

    public function create()
    {
        $collines = Colline::orderBy('name')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.joueur.create', compact('collines', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:joueurs,email',
            'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        Joueur::create($validated);

        return redirect()->route('admin.joueurs.index')
                        ->with('success', 'Joueur créé avec succès.');
    }

    public function show(Joueur $joueur)
    {
        $joueur->load(['colline', 'categorie']);
        
        return view('admin.joueurs.show', compact('joueur'));
    }

    public function edit(Joueur $joueur)
    {
        $collines = Colline::orderBy('name')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.joueur.edit', compact('joueur', 'collines', 'categories'));
    }

    public function update(Request $request, Joueur $joueur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('joueurs', 'email')->ignore($joueur->id)
            ],
            'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $joueur->update($validated);

        return redirect()->route('admin.joueurs.index')
                        ->with('success', 'Joueur modifié avec succès.');
    }

    public function destroy(Joueur $joueur)
    {
        try {
            $joueur->delete();
            
            return redirect()->route('admin.joueurs.index')
                            ->with('success', 'Joueur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.joueurs.index')
                            ->with('error', 'Erreur lors de la suppression du joueur.');
        }
    }
}