<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Colline;
use App\Models\Joueur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\GalleryImage;


class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les dernières actualités publiées
        $actualites = Post::with(['typePost', 'user'])
            ->latest('date_post')
            ->limit(3)
            ->get();

        // Récupérer les catégories et collines pour le formulaire d'inscription
        $categories = Categorie::all();
        $collines = Colline::all();

        // Récupérer les images de la galerie (par ex. les 12 plus récentes)
        $galleryImages = GalleryImage::latest()->take(12)->get();

        return view('judo', compact('actualites', 'categories', 'collines', 'galleryImages'));
    }

    public function storeInscription(Request $request)
    {
        // Validation complète des données
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:2|max:255',
            'prenom' => 'required|string|min:2|max:255',
            'email' => 'nullable|email|unique:joueurs,email',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date|before:today',
            'sexe' => 'nullable|in:M,F',
            'lieu_naissance' => 'nullable|string|max:255',
            'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'sexe.in' => 'Le sexe doit être M ou F.',
            'colline_id.required' => 'Veuillez sélectionner votre colline/quartier.',
            'colline_id.exists' => 'La colline sélectionnée n\'existe pas.',
            'categorie_id.required' => 'Veuillez sélectionner une catégorie.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ]);

        // Validation personnalisée du téléphone
        $validator->after(function ($validator) use ($request) {
            $this->validatePhoneNumber($validator, $request);
        });

        // Si validation échoue
        if ($validator->fails()) {

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            // Nettoyer et formater les données avant insertion
            $cleanData = [
                'nom' => $this->cleanName($request->nom),
                'prenom' => $this->cleanName($request->prenom),
                'email' => $request->email ? strtolower(trim($request->email)) : null,
                'telephone' => $request->telephone ? $this->formatPhoneNumber($request->telephone) : null,
                'date_naissance' => $request->date_naissance,
                'sexe' => $request->sexe,
                'lieu_naissance' => $request->lieu_naissance ? $this->cleanName($request->lieu_naissance) : null,
                'colline_id' => (int) $request->colline_id,
                'categorie_id' => (int) $request->categorie_id,
            ];



            // INSERTION EN BASE DE DONNÉES
            $joueur = Joueur::create($cleanData);

            // Vérifier que l'insertion a réussi
            if (!$joueur || !$joueur->id) {
                throw new \Exception('Échec de l\'insertion en base de données');
            }

            // Réponse selon le type de requête
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Inscription réussie ! Nous vous contacterons bientôt pour confirmer votre inscription.',
                    'joueur' => [
                        'id' => $joueur->id,
                        'nom_complet' => $joueur->prenom . ' ' . $joueur->nom,
                        'email' => $joueur->email,
                        'created_at' => $joueur->created_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            return redirect()
                ->back()
                ->with('inscription_success', 'Inscription réussie ! Nous vous contacterons bientôt.');
        } catch (\Exception $e) {


            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'inscription. Détails: ' . $e->getMessage(),
                    'debug' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('inscription_error', 'Erreur lors de l\'inscription: ' . $e->getMessage());
        }
    }

    private function validatePhoneNumber($validator, $request)
    {
        if ($request->telephone) {
            $phone = $request->telephone;
            $patterns = [
                '/^\+257[67][0-9]{7}$/',
                '/^[67][0-9]{7}$/',
                '/^00257[67][0-9]{7}$/',
            ];

            $isValid = false;
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $phone)) {
                    $isValid = true;
                    break;
                }
            }
        }
    }

    private function cleanName($name)
    {
        if (!$name) return null;
        return ucwords(strtolower(trim(preg_replace('/\s+/', ' ', $name))));
    }

    private function formatPhoneNumber($phone)
    {
        if (!$phone) return null;

        $phone = preg_replace('/[^\d+]/', '', $phone);

        if (strlen($phone) === 8 && in_array($phone[0], ['6', '7'])) {
            return '+257' . $phone;
        }

        if (str_starts_with($phone, '00257')) {
            return '+' . substr($phone, 2);
        }

        return $phone;
    }
}
