<?php

// app/Http/Controllers/Admin/PostController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TypePost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('typePost', 'user');

        // Filtres
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('type_id')) {
            $query->byType($request->type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest('date_post')->paginate(15);
        $typePosts = TypePost::all();

        return view('admin.post.index', compact('posts', 'typePosts'));
    }

    public function create()
    {
        $typePosts = TypePost::all();
        return view('admin.post.create', compact('typePosts'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Set user_id to current authenticated user
        $data['user_id'] = auth()->id();
        
        // Set default status if not provided
        $data['status'] = $data['status'] ?? 'draft';

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function show(Post $post)
    {
        $post->load('typePost', 'user');
        return view('admin.post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $typePosts = TypePost::all();
        return view('admin.post.edit', compact('post', 'typePosts'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Article modifié avec succès.');
    }

    public function destroy(Post $post)
    {
        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    public function toggleStatus(Post $post)
    {
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update(['status' => $newStatus]);

        $message = $newStatus === 'published' ? 'Article publié avec succès.' : 'Article mis en brouillon.';

        return redirect()
            ->back()
            ->with('success', $message);
    }

    public function preview(Post $post)
    {
        return view('admin.posts.preview', compact('post'));
    }

    public function search(Request $request)
    {
        $query = Post::with('typePost', 'user');

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        $posts = $query->limit(10)->get();

        return response()->json([
            'data' => $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'titre' => $post->titre,
                    'extrait' => $post->extrait,
                    'type' => $post->typePost?->nom,
                    'status' => $post->status,
                    'date_post' => $post->date_post_formatee,
                ];
            })
        ]);
    }
}

// app/Http/Requests/JoueurRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JoueurRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $joueurId = $this->route('joueur')?->id;

        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                Rule::unique('joueurs', 'email')->ignore($joueurId)
            ],
            'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'sexe.in' => 'Le sexe doit être M ou F.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'colline_id.required' => 'La colline est obligatoire.',
            'colline_id.exists' => 'La colline sélectionnée n\'existe pas.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ];
    }
}

// app/Http/Requests/CategorieRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $categorieId = $this->route('categorie')?->id;

        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'nom')->ignore($categorieId)
            ],
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.unique' => 'Cette catégorie existe déjà.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ];
    }
}

// app/Http/Requests/TypePostRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $typePostId = $this->route('type_post')?->id;

        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('type_posts', 'nom')->ignore($typePostId)
            ],
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom du type de post est obligatoire.',
            'nom.unique' => 'Ce type de post existe déjà.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ];
    }
}

// app/Http/Requests/PostRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'typepost_id' => 'required|exists:type_posts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_post' => 'nullable|date',
            'lieu_evenement' => 'nullable|string|max:255',
            'date_evenement_debut' => 'nullable|date',
            'date_evenement_fin' => 'nullable|date|after_or_equal:date_evenement_debut',
            'niveau_competition' => 'nullable|in:Local,Régional,National,International',
            'resultats' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'is_featured' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'typepost_id.required' => 'Le type de post est obligatoire.',
            'typepost_id.exists' => 'Le type de post sélectionné n\'existe pas.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            'date_evenement_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
            'niveau_competition.in' => 'Le niveau de compétition doit être Local, Régional, National ou International.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('is_featured')) {
            $this->merge([
                'is_featured' => $this->boolean('is_featured')
            ]);
        }
    }
}