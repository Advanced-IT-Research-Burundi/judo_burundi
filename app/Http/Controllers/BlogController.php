<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\TypePost;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer tous les types de posts pour les filtres
        $typePosts = TypePost::all();
        
        // Query de base pour les actualités avec relations
        $query = Post::with(['user', 'typePost'])
                          ->orderBy('date_post', 'desc');
        
        // Filtrer par recherche si présente
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('contenu', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtrer par type si présent
        if ($request->filled('type')) {
            $query->whereHas('typePost', function($q) use ($request) {
                $q->where('nom', $request->get('type'));
            });
        }
        
        // Paginer les résultats (12 actualités par page)
        $actualites = $query->paginate(12);
        
        return view('pages.blog', compact('actualites', 'typePosts'));
    }

    public function show(Post $post)
    {
        // Charger les relations nécessaires
        $post->load(['user', 'typePost']);
        
        return view('pages.actualite', compact('post'));
    }
}