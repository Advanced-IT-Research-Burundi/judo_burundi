<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JoueurController extends Controller
{
    /**
     * Liste des joueurs
     */
    public function index()
    {
        $joueurs = Joueur::with('club')->latest()->paginate(10);
        return view('admin.joueur.index', compact('joueurs'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $clubs = Club::all();
        return view('admin.joueur.create', compact('clubs'));
    }

    /**
     * Enregistrement d’un joueur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poids' => 'nullable|numeric',
            'taille' => 'nullable|numeric',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|max:1',
            'clubs_id' => 'required|exists:clubs,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        // Upload de l’image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('joueurs', 'public');
            $data['image'] = $path;
        }

        Joueur::create($data);

        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur ajouté avec succès.');
    }

    /**
     * Affichage des détails
     */
    public function show(Joueur $joueur)
    {
        return view('admin.joueur.show', compact('joueur'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Joueur $joueur)
    {
        $clubs = Club::all();
        return view('admin.joueur.edit', compact('joueur', 'clubs'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Joueur $joueur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poids' => 'nullable|numeric',
            'taille' => 'nullable|numeric',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|max:1',
            'clubs_id' => 'required|exists:clubs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        // Si une nouvelle image est envoyée, supprimer l’ancienne
        if ($request->hasFile('image')) {
            if ($joueur->image && Storage::disk('public')->exists($joueur->image)) {
                Storage::disk('public')->delete($joueur->image);
            }
            $path = $request->file('image')->store('joueurs', 'public');
            $data['image'] = $path;
        }

        $joueur->update($data);

        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur modifié avec succès.');
    }

    /**
     * Suppression d’un joueur
     */
    public function destroy(Joueur $joueur)
    {
        if ($joueur->image && Storage::disk('public')->exists($joueur->image)) {
            Storage::disk('public')->delete($joueur->image);
        }

        $joueur->delete();

        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur supprimé avec succès.');
    }
}
