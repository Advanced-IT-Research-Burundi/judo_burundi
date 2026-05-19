<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Categorie;
// use App\Models\Colline;
use App\Models\Joueur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\GalleryImage;
use App\Models\Membre;

class HomeController extends Controller
{
    public function index()
    {
        $postsQuery = Post::query()->latest();
        if (Schema::hasColumn('posts', 'typepost_id')) {
            $postsQuery->with('typePost');
        }
        $actualites = $postsQuery->take(6)->get();

        // Récupérer les images de la galerie (par ex. les 12 plus récentes)
        $galleryImages = GalleryImage::latest()->take(12)->get();

        return view('judo', compact('actualites',  'galleryImages'));
    }

    public function storeInscription(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:membres,email',
            'telephone' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        // Enregistrement
        $membre = Membre::create($validated);

        // Retour JSON pour le JS
        return response()->json([
            'success' => true,
            'message' => 'Inscription réussie.',
            'data' => $membre,
        ]);
    }

}
