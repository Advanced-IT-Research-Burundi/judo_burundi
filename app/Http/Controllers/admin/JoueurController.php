<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Categorie;
use App\Models\Colline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JoueurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Joueur::with(['categorie', 'colline']);

            // Filtres
            if ($request->filled('search')) {
                $query->search($request->search);
            }

            if ($request->filled('categorie')) {
                $query->byCategorie($request->categorie);
            }

            if ($request->filled('sexe')) {
                $query->bySexe($request->sexe);
            }

            if ($request->filled('age_min') || $request->filled('age_max')) {
                $query->byAge($request->age_min, $request->age_max);
            }

            $joueurs = $query->orderBy('nom')->orderBy('prenom')->paginate(15);
            $categories = Categorie::orderBy('nom')->get();
            $collines = Colline::orderBy('nom')->get();

            return view('admin.joueurs.index', compact('joueurs', 'categories', 'collines'));

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des joueurs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du chargement des joueurs.');
        }
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        $collines = Colline::orderBy('nom')->get();
        return view('admin.joueurs.create', compact('categories', 'collines'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'date_naissance' => 'nullable|date|before:today',
                'lieu_naissance' => 'nullable|string|max:255',
                'sexe' => 'nullable|in:M,F',
                'telephone' => 'nullable|string|max:20|unique:joueurs,telephone',
                'email' => 'nullable|email|max:255|unique:joueurs,email',
                'colline_id' => 'required|exists:collines,id',
                'categorie_id' => 'required|exists:categories,id'
            ]);

            Joueur::create($validatedData);

            return redirect()->route('admin.joueurs.index')
                           ->with('success', 'Joueur créé avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du joueur: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création du joueur.');
        }
    }

    public function show(Joueur $joueur)
    {
        try {
            $joueur->load(['categorie', 'colline.zone']);
            return view('admin.joueurs.show', compact('joueur'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du joueur: ' . $e->getMessage());
            return redirect()->route('admin.joueurs.index')->with('error', 'Joueur introuvable.');
        }
    }

    public function edit(Joueur $joueur)
    {
        $categories = Categorie::orderBy('nom')->get();
        $collines = Colline::orderBy('nom')->get();
        return view('admin.joueurs.edit', compact('joueur', 'categories', 'collines'));
    }

    public function update(Request $request, Joueur $joueur)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'date_naissance' => 'nullable|date|before:today',
                'lieu_naissance' => 'nullable|string|max:255',
                'sexe' => 'nullable|in:M,F',
                'telephone' => 'nullable|string|max:20|unique:joueurs,telephone,' . $joueur->id,
                'email' => 'nullable|email|max:255|unique:joueurs,email,' . $joueur->id,
                'colline_id' => 'required|exists:collines,id',
                'categorie_id' => 'required|exists:categories,id'
            ]);

            $joueur->update($validatedData);

            return redirect()->route('admin.joueurs.index')
                           ->with('success', 'Joueur mis à jour avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du joueur: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la mise à jour du joueur.');
        }
    }

    public function destroy(Joueur $joueur)
    {
        try {
            $joueur->delete();

            return redirect()->route('admin.joueurs.index')
                           ->with('success', 'Joueur supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du joueur: ' . $e->getMessage());
            return redirect()->route('admin.joueurs.index')
                           ->with('error', 'Erreur lors de la suppression du joueur.');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'exists:joueurs,id'
            ]);

            $deletedCount = Joueur::whereIn('id', $request->ids)->delete();

            return redirect()->route('admin.joueurs.index')
                           ->with('success', "{$deletedCount} joueur(s) supprimé(s) avec succès !");

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression multiple: ' . $e->getMessage());
            return redirect()->route('admin.joueurs.index')
                           ->with('error', 'Erreur lors de la suppression multiple.');
        }
    }

    public function export()
    {
        try {
            $joueurs = Joueur::with(['categorie', 'colline'])->get();
            
            $filename = 'joueurs_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($joueurs) {
                $file = fopen('php://output', 'w');
                
                // En-têtes CSV
                fputcsv($file, [
                    'ID', 'Nom', 'Prénom', 'Date de naissance', 'Age', 'Sexe',
                    'Téléphone', 'Email', 'Lieu de naissance', 'Catégorie', 'Colline'
                ]);

                // Données
                foreach ($joueurs as $joueur) {
                    fputcsv($file, [
                        $joueur->id,
                        $joueur->nom,
                        $joueur->prenom,
                        $joueur->date_naissance ? $joueur->date_naissance->format('d/m/Y') : '',
                        $joueur->age ?? '',
                        $joueur->sexe ?? '',
                        $joueur->telephone ?? '',
                        $joueur->email ?? '',
                        $joueur->lieu_naissance ?? '',
                        $joueur->categorie->nom ?? '',
                        $joueur->colline->nom ?? ''
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'export: ' . $e->getMessage());
            return redirect()->route('admin.joueurs.index')
                           ->with('error', 'Erreur lors de l\'export.');
        }
    }
}