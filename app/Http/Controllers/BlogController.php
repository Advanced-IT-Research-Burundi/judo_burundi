<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
        }

        $posts = $query->paginate(12);

        return view('pages.blog', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $relatedPosts = Post::where('id', '!=', $post->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(3)
                            ->get();

        return view('actualites.index', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }
}
