<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\TypePost;
use App\Models\User;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Récupérer les posts récents avec leurs relations
            $posts = Post::with(['typePost'])
                        ->orderBy('date_post', 'desc') // Tri par date de post
                        ->limit(6) // Limiter à 6 posts sur la page d'accueil
                        ->get();

            return view('judo', compact('posts'));

        } catch (\Exception $e) {
            // En cas d'erreur, logger l'erreur et retourner une collection vide
            // \Log::error('Erreur lors de la récupération des posts: ' . $e->getMessage());
            
            return view('judo', ['posts' => collect([])]);
        }
    }

    /**
     * Méthode alternative si vos relations ont des noms différents
     */
    public function indexAlternative()
    {
        try {
            // Si vous n'avez pas de relation typePost, juste récupérer les posts simples
            $posts = Post::with('user')
                        ->orderBy('date_post', 'desc')
                        ->limit(6)
                        ->get();

            // Récupérer les types de posts séparément si nécessaire
            $typePosts = [];
            if (class_exists('App\Models\TypePost')) {
                $typePosts = TypePost::all();
            }

            return view('judo', compact('posts', 'typePosts'));

        } catch (\Exception $e) {
            // \Log::error('Erreur: ' . $e->getMessage());
            return view('judo', ['posts' => collect([]), 'typePosts' => []]);
        }
    }
}
