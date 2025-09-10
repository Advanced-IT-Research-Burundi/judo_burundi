<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Joueur;
use App\Models\Post;
use App\Models\Categorie;
use App\Models\TypePost;


class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_joueurs' => Joueur::count(),
            'total_posts' => Post::count(),
            'total_categories' => Categorie::count(),
            'total_types_post' => TypePost::count(),
            'posts_recents' => Post::with(['typePost'])
                ->orderBy('date_post', 'desc')
                ->take(5)
                ->get(),
            'joueurs_recents' => Joueur::with(['colline.zone.commune', 'categorie'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
