<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Categorie;
use App\Models\Colline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class JoueurController extends Controller
{
    public function index(Request $request)
    {
        // Validation des filtres
        $request->validate([
            'search' => 'nullable|string|max:255',
            'categorie_id' => 'nullable|exists:categories,id',
            'sexe' => 'nullable|in:M,F',
        ]);

        $query = Joueur::with('categorie', 'colline');

        // Filtres
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('categorie_id')) {
            $query->byCategorie($request->categorie_id);
        }

        if ($request->filled('sexe')) {
            $query->bySexe($request->sexe);
        }

        $joueurs = $query->latest()->paginate(15);
        $categories = Categorie::all();

        return view('admin.joueur.index', compact('joueurs', 'categories'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('admin.joueur.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation principale
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:2|max:255',
            'prenom' => 'required|string|min:2|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'telephone' => 'nullable|string|max:20|unique:joueurs,telephone',
            'email' => 'nullable|email|max:255|unique:joueurs,email',
            // 'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id',
        ], [
            // Messages personnalisés
            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'lieu_naissance.max' => 'Le lieu de naissance ne peut pas dépasser 255 caractères.',
            'sexe.in' => 'Le sexe doit être M (Masculin) ou F (Féminin).',
            'telephone.max' => 'Le téléphone ne peut pas dépasser 20 caractères.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé par un autre joueur.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée par un autre joueur.',
            // 'colline_id.required' => 'La colline/quartier est obligatoire.',
            // 'colline_id.exists' => 'La colline sélectionnée n\'existe pas.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ]);

        // Validations personnalisées
        $validator->after(function ($validator) use ($request) {
            $this->validateAgeCategory($validator, $request);
            $this->validatePhoneNumber($validator, $request);
            $this->validateGenderCategory($validator, $request);
        });

        // Si validation échoue
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Nettoyer et formater les données
        $data = $this->cleanJoueurData($request->all());

        try {
            $joueur = Joueur::create($data);
            
            Log::info('Nouveau joueur créé', [
                'joueur_id' => $joueur->id,
                'nom_complet' => $joueur->nom_complet,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.joueurs.index')
                ->with('success', 'Joueur créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur création joueur: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la création du joueur.')
                ->withInput();
        }
    }

    public function show(Joueur $joueur)
    {
        $joueur->load('categorie');
        return view('admin.joueur.show', compact('joueur'));
    }

    public function edit(Joueur $joueur)
    {
        $categories = Categorie::all();
        return view('admin.joueur.edit', compact('joueur', 'categories'));
    }

    public function update(Request $request, Joueur $joueur)
    {
        // dd('update...');
        // Validation principale avec ignore pour update
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:2|max:255',
            'prenom' => 'required|string|min:2|max:255',
            'date_naissance' => 'nullable|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F',
            'telephone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('joueurs', 'telephone')->ignore($joueur->id)
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('joueurs', 'email')->ignore($joueur->id)
            ],
            // 'colline_id' => 'required|exists:collines,id',
            'categorie_id' => 'required|exists:categories,id',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'sexe.in' => 'Le sexe doit être M ou F.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            // 'colline_id.required' => 'La colline est obligatoire.',
            // 'colline_id.exists' => 'La colline sélectionnée n\'existe pas.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        ]);

        // Validations personnalisées
        $validator->after(function ($validator) use ($request) {
            $this->validateAgeCategory($validator, $request);
            $this->validatePhoneNumber($validator, $request);
            $this->validateGenderCategory($validator, $request);
        });

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Nettoyer et formater les données
        $data = $this->cleanJoueurData($request->all());

        try {
            $joueur->update($data);
            
            Log::info('Joueur modifié', [
                'joueur_id' => $joueur->id,
                'nom_complet' => $joueur->nom_complet,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.joueurs.index')
                ->with('success', 'Joueur modifié avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur modification joueur: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la modification du joueur.')
                ->withInput();
        }
    }

    public function destroy(Joueur $joueur)
    {
        try {
            $nomComplet = $joueur->nom_complet;
            $joueur->delete();
            
            Log::info('Joueur supprimé', [
                'nom_complet' => $nomComplet,
                'admin_id' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.joueurs.index')
                ->with('success', 'Joueur supprimé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur suppression joueur: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la suppression du joueur.');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255',
        ]);

        $query = Joueur::with('categorie');

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        $joueurs = $query->limit(10)->get();

        return response()->json([
            'data' => $joueurs->map(function ($joueur) {
                return [
                    'id' => $joueur->id,
                    'nom_complet' => $joueur->nom_complet,
                    'email' => $joueur->email,
                    'categorie' => $joueur->categorie?->nom,
                ];
            })
        ]);
    }

    public function exportPdf(Joueur $joueur)
    {
        // Logique pour exporter en PDF
        // Vous pouvez utiliser barryvdh/laravel-dompdf ou tcpdf
        return response()->json([
            'message' => 'Export PDF en développement',
            'joueur' => $joueur->nom_complet
        ]);
    }

    /**
     * Valider que l'âge correspond à la catégorie
     */
    private function validateAgeCategory($validator, $request)
    {
        if (!$request->date_naissance || !$request->categorie_id) {
            return;
        }

        $age = Carbon::parse($request->date_naissance)->age;
        $categorie = Categorie::find($request->categorie_id);
        
        if (!$categorie) {
            return;
        }

        // Règles d'âge selon les catégories
        $ageRules = [
            'Minimes' => [16, 17, 'Minimes (16-17 ans)'],
            'Cadets' => [18, 19, 'Cadets/Cadettes (18-19 ans)'],
            'Cadettes' => [18, 19, 'Cadets/Cadettes (18-19 ans)'],
            'Juniors' => [20, 21, 'Juniors (20-21 ans)'],
            'Seniors' => [22, 60, 'Seniors (22+ ans)'],
        ];

        foreach ($ageRules as $categoryName => [$minAge, $maxAge, $description]) {
            if (str_contains($categorie->nom, $categoryName)) {
                if ($age < $minAge || ($maxAge < 60 && $age > $maxAge)) {
                    $validator->errors()->add(
                        'date_naissance', 
                        "L'âge ({$age} ans) ne correspond pas à la catégorie {$description}."
                    );
                }
                break;
            }
        }
    }

    /**
     * Valider le format du numéro de téléphone
     */
    private function validatePhoneNumber($validator, $request)
    {
        if (!$request->telephone) {
            return;
        }

        $phone = $request->telephone;
        
        // Patterns pour numéros burundais
        $patterns = [
            '/^\+257[67][0-9]{7}$/',           // +257 6/7 + 7 chiffres
            '/^00257[67][0-9]{7}$/',           // 00257 6/7 + 7 chiffres
            '/^257[67][0-9]{7}$/',             // 257 6/7 + 7 chiffres
            '/^[67][0-9]{7}$/',                // 6/7 + 7 chiffres (local)
        ];

        $isValid = false;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                $isValid = true;
                break;
            }
        }

        // if (!$isValid) {
        //     $validator->errors()->add(
        //         'telephone', 
        //         'Le numéro doit être au format burundais (+257 79 123 456 ou 79 123 456).'
        //     );
        // }
    }

    /**
     * Valider que le sexe correspond à la catégorie
     */
    private function validateGenderCategory($validator, $request)
    {
        if (!$request->sexe || !$request->categorie_id) {
            return;
        }

        $categorie = Categorie::find($request->categorie_id);
        
        if (!$categorie) {
            return;
        }

        // Vérifier si c'est une catégorie féminine
        $isFemaleCategory = str_contains($categorie->nom, 'F ') || 
                           str_contains($categorie->nom, 'Cadettes') ||
                           str_contains($categorie->nom, 'féminin');

        if ($isFemaleCategory && $request->sexe !== 'F') {
            $validator->errors()->add('sexe', 'Cette catégorie est réservée aux femmes.');
        }
    }

    /**
     * Nettoyer et formater les données du joueur
     */
    private function cleanJoueurData($data)
    {
        // Nettoyer les noms
        if (isset($data['nom'])) {
            $data['nom'] = $this->cleanName($data['nom']);
        }
        
        if (isset($data['prenom'])) {
            $data['prenom'] = $this->cleanName($data['prenom']);
        }
        
        // Nettoyer lieu de naissance
        if (isset($data['lieu_naissance']) && $data['lieu_naissance']) {
            $data['lieu_naissance'] = $this->cleanName($data['lieu_naissance']);
        }

        // Formater le téléphone
        if (isset($data['telephone']) && $data['telephone']) {
            $data['telephone'] = $this->formatPhoneNumber($data['telephone']);
        }

        // Nettoyer l'email
        if (isset($data['email']) && $data['email']) {
            $data['email'] = strtolower(trim($data['email']));
        }

        return $data;
    }

    /**
     * Nettoyer les champs nom/prénom
     */
    private function cleanName($name)
    {
        if (!$name) {
            return null;
        }

        // Supprimer espaces multiples et trim
        $name = trim(preg_replace('/\s+/', ' ', $name));
        
        // Capitaliser chaque mot (gère les tirets et apostrophes)
        return ucwords(strtolower($name), " \t\r\n\f\v-'.");
    }

    /**
     * Formater le numéro de téléphone
     */
    private function formatPhoneNumber($phone)
    {
        if (!$phone) {
            return null;
        }

        // Supprimer tous les caractères non numériques sauf le +
        $phone = preg_replace('/[^\d+]/', '', $phone);
        
        // Ajouter +257 si c'est un numéro local de 8 chiffres
        if (strlen($phone) === 8 && in_array($phone[0], ['6', '7'])) {
            $phone = '+257' . $phone;
        }
        
        // Convertir 00257 en +257
        if (str_starts_with($phone, '00257')) {
            $phone = '+' . substr($phone, 2);
        }
        
        // Convertir 257 en +257
        if (preg_match('/^257[67]/', $phone)) {
            $phone = '+' . $phone;
        }

        return $phone;
    }

}