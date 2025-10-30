<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Club;
use App\Models\Post;
use App\Models\Membre;
use App\Models\Competition;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalJoueurs' => Joueur::count(),
            'totalClubs' => Club::count(),
            'totalPosts' => Post::count(),
            'totalMembres' => Membre::count(),
            'totalCompetitions' => Competition::count(),
        ];

        $recentJoueurs = Joueur::with('club')
            ->latest()
            ->take(5)
            ->get();

        $recentPosts = Post::latest()
            ->take(5)
            ->get();

        $upcomingCompetitions = Competition::with(['clubDomicile', 'clubAdversaire'])
            ->where('date_competition', '>=', now())
            ->orderBy('date_competition')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentJoueurs', 'recentPosts', 'upcomingCompetitions'));
    }
}