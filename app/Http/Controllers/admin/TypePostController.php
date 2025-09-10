<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypePost;

class TypePostController extends Controller
{
    public function index()
    {
        $typesPosts = TypePost::withCount('posts')->paginate(10);
        return view('admin.typepost.index', compact('typesPosts'));
    }

    public function create()
    {
        return view('admin.typepost.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_posts',
            'description' => 'nullable|string'
        ]);

        TypePost::create($request->all());

        return redirect()->route('admin.typeposts.index')
            ->with('success', 'Type de post créé avec succès.');
    }

    public function show(TypePost $typePost)
    {
        $typePost->load(['posts.joueur']);
        return view('admin.typepost.show', compact('typePost'));
    }

    public function edit(TypePost $typepost)
    {
        return view('admin.typepost.edit', compact('typepost'));
    }

    public function update(Request $request, TypePost $typepost)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_posts,nom,' . $typepost->id,
            'description' => 'nullable|string'
        ]);

        $typepost->update($request->all());

        return redirect()->route('admin.typeposts.index')
            ->with('success', 'Type de post mis à jour avec succès.');
    }

    public function destroy(TypePost $typepost)
    {
        if ($typepost->posts()->count() > 0) {
            return redirect()->route('admin.typeposts.index')
                ->with('error', 'Impossible de supprimer ce type de post car il contient des posts.');
        }

        $typepost->delete();

        return redirect()->route('admin.typeposts.index')
            ->with('success', 'Type de post supprimé avec succès.');
    }
}
