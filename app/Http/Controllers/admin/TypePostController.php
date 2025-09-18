<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TypePostRequest;

class TypePostController extends Controller
{
    public function index()
    {
        $typePosts = TypePost::withCount('posts')
            ->latest()
            ->paginate(15);

        return view('admin.typepost.index', compact('typePosts'));
    }

    public function create()
    {
        return view('admin.typepost.create');
    }

    public function store(TypePostRequest $request)
    {
        $typePost = TypePost::create($request->validated());

        return redirect()
            ->route('admin.typepost.index')
            ->with('success', 'Type de post créé avec succès.');
    }

    public function show(TypePost $typePost)
    {
        $typePost->load(['posts' => function ($query) {
            $query->latest();
        }]);

        return view('admin.typepost.show', compact('typePost'));
    }

    public function edit(TypePost $typePost)
    {
        return view('admin.typepost.edit', compact('typePost'));
    }

    public function update(TypePostRequest $request, TypePost $typePost)
    {
        $typePost->update($request->validated());

        return redirect()
            ->route('admin.type-posts.index')
            ->with('success', 'Type de post modifié avec succès.');
    }

    public function destroy(TypePost $typePost)
    {
        if ($typePost->posts()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Impossible de supprimer ce type car il contient des posts.');
        }

        $typePost->delete();

        return redirect()
            ->route('admin.type-posts.index')
            ->with('success', 'Type de post supprimé avec succès.');
    }
}