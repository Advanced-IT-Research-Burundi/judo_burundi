<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class ActualiteController extends Controller
{
        public function index(Request $request)
    {
        $query = Post::with(['typePost', 'user'])
            ->where('status', 'published');

        // Filtrer par type si spécifié
        if ($request->filled('type')) {
            $query->whereHas('typePost', function($q) use ($request) {
                $q->where('nom', $request->type);
            });
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%");
            });
        }

        $actualites = $query->latest('date_post')->paginate(12);
        $typePosts = \App\Models\TypePost::whereHas('posts', function($q) {
            $q->where('status', 'published');
        })->get();

        return view('actualites.index', compact('actualites', 'typePosts'));
    }

    public function show(Post $post)
    {
        // Vérifier que le post est publié
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['typePost', 'user']);
        
        // Articles similaires
        $relatedPosts = Post::where('status', 'published')
            ->where('typepost_id', $post->typepost_id)
            ->where('id', '!=', $post->id)
            ->latest('date_post')
            ->limit(3)
            ->get();

        return view('actualites.show', compact('post', 'relatedPosts'));
    }

}
