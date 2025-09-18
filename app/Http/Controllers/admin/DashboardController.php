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
        // Statistiques principales
        $stats = [
            'total_joueurs' => Joueur::count(),
            'total_posts' => Post::count(),
            'total_categories' => Categorie::count(),
            'total_contacts' => Contact::count(),
            'nouveaux_joueurs_semaine' => Joueur::where('created_at', '>=', Carbon::now()->subWeek())->count(),
            'events_a_venir' => Post::upcoming()->count(),
        ];

        // Données récentes
        $stats['posts_recents'] = Post::with(['user', 'typePost'])
            ->latest()
            ->take(5)
            ->get();

        $stats['joueurs_recents'] = Joueur::with(['categorie', 'colline'])
            ->latest()
            ->take(5)
            ->get();

        $stats['events_prochains'] = Post::upcoming()
            ->with(['user', 'typePost'])
            ->orderBy('date_evenement_debut', 'asc')
            ->take(5)
            ->get();

        // Statistiques par catégorie
        $stats['joueurs_par_categorie'] = Categorie::withCount('joueurs')
            ->orderBy('joueurs_count', 'desc')
            ->get();

        // Statistiques par type de post
        $stats['posts_par_type'] = TypePost::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        return view('admin.dashboard', compact('stats'));
    }
}
