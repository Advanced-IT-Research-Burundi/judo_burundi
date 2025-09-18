<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TypePost;
use App\Models\Joueur;
use App\Models\Categorie;
use Carbon\Carbon;
use App\Models\Contact;

class DashboardController extends Controller
{
  public function index()
    {
        $stats = $this->getStats();
        $recentJoueurs = Joueur::with('categorie', 'colline')
            ->latest()
            ->limit(5)
            ->get();
            
        $recentPosts = Post::with('typePost', 'user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentJoueurs', 'recentPosts'));
    }

    public function getStats()
    {
        $totalJoueurs = Joueur::count();
        $totalCategories = Categorie::count();
        $totalPosts = Post::count();
        $totalCompetitions = Post::whereHas('typePost', function ($query) {
            $query->where('nom', 'Compétition');
        })->count();

        // Statistiques mensuelles
        $joueursParMois = Joueur::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Répartition par catégorie
        $repartitionCategories = Categorie::withCount('joueurs')
            ->get()
            ->map(function ($categorie) {
                return [
                    'nom' => $categorie->nom,
                    'total' => $categorie->joueurs_count
                ];
            });

        // Événements à venir
        $evenementsAVenir = Post::whereNotNull('date_evenement_debut')
            ->where('date_evenement_debut', '>=', Carbon::now())
            ->orderBy('date_evenement_debut')
            ->limit(3)
            ->get();

        return [
            'totalJoueurs' => $totalJoueurs,
            'totalCategories' => $totalCategories,
            'totalPosts' => $totalPosts,
            'totalCompetitions' => $totalCompetitions,
            'joueursParMois' => $joueursParMois,
            'repartitionCategories' => $repartitionCategories,
            'evenementsAVenir' => $evenementsAVenir,
        ];
    }
}
