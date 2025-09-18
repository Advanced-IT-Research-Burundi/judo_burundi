<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TypePostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = TypePost::withCount('posts');

            if ($request->filled('search')) {
                $query->search($request->search);
            }

            $typesPosts = $query->orderBy('nom')->paginate(15);

            return view('admin.type-posts.index', compact('typesPosts'));

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des types de posts: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du chargement des types de posts.');
        }
    }

    public function create()
    {
        return view('admin.type-posts.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:type_posts,nom',
                'description' => 'nullable|string'
            ]);

            TypePost::create($validatedData);

            return redirect()->route('admin.type-posts.index')
                           ->with('success', 'Type de post créé avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du type de post: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création du type de post.');
        }
    }

    public function show(TypePost $typePost)
    {
        try {
            $typePost->load('posts.user');
            return view('admin.type-posts.show', compact('typePost'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du type de post: ' . $e->getMessage());
            return redirect()->route('admin.type-posts.index')->with('error', 'Type de post introuvable.');
        }
    }

    public function edit(TypePost $typePost)
    {
        return view('admin.type-posts.edit', compact('typePost'));
    }

    public function update(Request $request, TypePost $typePost)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:type_posts,nom,' . $typePost->id,
                'description' => 'nullable|string'
            ]);

            $typePost->update($validatedData);

            return redirect()->route('admin.type-posts.index')
                           ->with('success', 'Type de post mis à jour avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du type de post: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la mise à jour du type de post.');
        }
    }

    public function destroy(TypePost $typePost)
    {
        try {
            if ($typePost->posts()->count() > 0) {
                return redirect()->route('admin.type-posts.index')
                               ->with('error', 'Impossible de supprimer ce type car il contient des posts.');
            }

            $typePost->delete();

            return redirect()->route('admin.type-posts.index')
                           ->with('success', 'Type de post supprimé avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du type de post: ' . $e->getMessage());
            return redirect()->route('admin.type-posts.index')
                           ->with('error', 'Erreur lors de la suppression du type de post.');
        }
    }
}