<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TypePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Post::with(['user', 'typePost']);

            if ($request->filled('type')) {
                $query->where('typepost_id', $request->type);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('contenu', 'like', "%{$search}%")
                      ->orWhere('lieu_evenement', 'like', "%{$search}%");
                });
            }

            if ($request->filled('date_from')) {
                $query->where('date_post', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->where('date_post', '<=', $request->date_to);
            }

            $posts = $query->latest('date_post')->paginate(15);
            $typesPosts = TypePost::all();

            return view('admin.post.index', compact('posts', 'typesPosts'));
            
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement des posts: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du chargement des posts.');
        }
    }

    public function create()
    {
        try {
            $typesPosts = TypePost::all();
            return view('admin.post.create', compact('typesPosts'));
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement de la page de création: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')->with('error', 'Erreur lors du chargement de la page.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'typepost_id' => 'required|exists:type_posts,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'date_post' => 'required|date',
                'lieu_evenement' => 'nullable|string|max:255',
                'date_evenement_debut' => 'nullable|date',
                'date_evenement_fin' => 'nullable|date|after_or_equal:date_evenement_debut',
                'niveau_competition' => 'nullable|in:Local,National,International',
                'resultats' => 'nullable|string',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('posts', 'public');
                $validatedData['image'] = $imagePath;
            }

            $validatedData['user_id'] = Auth::id();

            $post = Post::create($validatedData);

            return redirect()->route('admin.posts.index')
                            ->with('success', 'Post créé avec succès!');
                            
        } catch (Exception $e) {
            Log::error('Erreur lors de la création du post: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création du post: ' . $e->getMessage());
        }
    }

    public function show(Post $post)
    {
        try {
            $post->load(['user', 'typePost']);
            return view('admin.post.show', compact('post'));
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'affichage du post: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')->with('error', 'Post introuvable.');
        }
    }

    public function edit(Post $post)
    {
        try {
            $typesPosts = TypePost::all();
            return view('admin.post.edit', compact('post', 'typesPosts'));
        } catch (Exception $e) {
            Log::error('Erreur lors du chargement de la page d\'édition: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')->with('error', 'Erreur lors du chargement de la page.');
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            $validatedData = $request->validate([
                'titre' => 'required|string|max:255',
                'contenu' => 'required|string',
                'typepost_id' => 'required|exists:type_posts,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'date_post' => 'required|date',
                'lieu_evenement' => 'nullable|string|max:255',
                'date_evenement_debut' => 'nullable|date',
                'date_evenement_fin' => 'nullable|date|after_or_equal:date_evenement_debut',
                'niveau_competition' => 'nullable|in:Local,National,International',
                'resultats' => 'nullable|string',
            ]);

            if ($request->hasFile('image')) {
                if ($post->image && Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
                
                $imagePath = $request->file('image')->store('posts', 'public');
                $validatedData['image'] = $imagePath;
            }

            $post->update($validatedData);

            return redirect()->route('admin.posts.index')
                            ->with('success', 'Post mis à jour avec succès!');
                            
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du post: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la mise à jour du post: ' . $e->getMessage());
        }
    }

    public function destroy(Post $post)
    {
        try {
            Log::info('Tentative de suppression du post ID: ' . $post->id);
            
            // Supprimer l'image si elle existe
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
                Log::info('Image supprimée: ' . $post->image);
            }

            // Supprimer le post
            $post->delete();
            
            Log::info('Post supprimé avec succès: ' . $post->id);

            return redirect()->route('admin.posts.index')
                            ->with('success', 'Post supprimé avec succès!');
                            
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du post: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.posts.index')
                           ->with('error', 'Erreur lors de la suppression du post: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:posts,id'
            ]);

            $posts = Post::whereIn('id', $request->ids)->get();
            $deletedCount = 0;

            foreach ($posts as $post) {
                // Supprimer l'image si elle existe
                if ($post->image && Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
                
                $post->delete();
                $deletedCount++;
            }

            return redirect()->route('admin.posts.index')
                           ->with('success', "{$deletedCount} post(s) supprimé(s) avec succès!");
                           
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression multiple: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')
                           ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function removeImage(Post $post)
    {
        try {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
                $post->update(['image' => null]);
                
                return redirect()->back()->with('success', 'Image supprimée avec succès!');
            }
            
            return redirect()->back()->with('error', 'Aucune image à supprimer.');
            
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression de l\'image: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'image.');
        }
    }
}