<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\TypePost;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'typepost']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('contenu', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('typepost_id')) {
            $query->where('typepost_id', $request->typepost_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date_post', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_post', '<=', $request->date_fin);
        }

        // Tri par défaut : posts les plus récents
        $posts = $query->orderBy('date_post', 'desc')->paginate(15);

        // Données pour les filtres
        $typeposts = TypePost::orderBy('nom')->get();
        $users = User::orderBy('name')->get();

        return view('admin.post.index', compact('posts', 'typeposts', 'users'));
    }

    public function create()
    {
        $typeposts = TypePost::orderBy('nom')->get();
        $users = User::orderBy('name')->get();

        return view('admin.post.create', compact('typeposts', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string|min:10',
            'user_id' => 'required|exists:users,id',
            'typepost_id' => 'required|exists:type_posts,id',
            'date_post' => 'nullable|date'
        ]);

        // Si aucune date n'est fournie, utiliser maintenant
        if (!$validated['date_post']) {
            $validated['date_post'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post créé avec succès.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'typepost']);
        
        return view('admin.post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $typeposts = TypePost::orderBy('nom')->get();
        $users = User::orderBy('name')->get();

        return view('admin.post.edit', compact('post', 'typeposts', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'contenu' => 'required|string|min:10',
            'user_id' => 'required|exists:users,id',
            'typepost_id' => 'required|exists:type_posts,id',
            'date_post' => 'required|date'
        ]);

        $post->update($validated);

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post modifié avec succès.');
    }

    public function destroy(Post $post)
    {
        try {
            $post->delete();
            
            return redirect()->route('admin.posts.index')
                            ->with('success', 'Post supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')
                            ->with('error', 'Erreur lors de la suppression du post.');
        }
    }

    public function statistics()
    {
        $stats = [
            'total_posts' => Post::count(),
            'posts_aujourd_hui' => Post::publiesAujourdhui()->count(),
            'posts_cette_semaine' => Post::publiesCetteSemaine()->count(),
            'posts_par_type' => TypePost::withCount('posts')->get(),
            'auteurs_actifs' => User::has('posts')->withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get(),
            'posts_recents' => Post::with(['user', 'typepost'])->recents()->take(5)->get()
        ];

        return view('admin.posts.statistics', compact('stats'));
    }
}