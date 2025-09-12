<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        // Affiche la page de contact
        return view('pages.contact');
    }

    public function submit(Request $request)
    {
        try {
            // Validation des données
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'sujet' => 'required|string',
                'message' => 'required|string',
            ], [
                'name.required' => 'Le nom est obligatoire.',
                'name.min' => 'Le nom doit contenir au moins 2 caractères.',
                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'Veuillez entrer un email valide.',
                'sujet.required' => 'Le sujet est obligatoire.',
                'sujet.min' => 'Le sujet doit contenir au moins 3 caractères.',
                'message.required' => 'Le message est obligatoire.',
                'message.min' => 'Le message doit contenir au moins 10 caractères.',
                'message.max' => 'Le message ne peut pas dépasser 1000 caractères.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('contact_error', 'Veuillez corriger les erreurs dans le formulaire.');
            }

            // Vérifier si l'email existe déjà (optionnel)
            $existingContact = Contact::where('email', $request->email)->first();
            if ($existingContact) {
                // Mettre à jour le contact existant
                $existingContact->update([
                    'name' => $request->name,
                    'sujet' => $request->sujet,
                    'message' => $request->message,
                ]);
            } else {
                // Créer un nouveau contact
                Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'sujet' => $request->sujet,
                    'message' => $request->message,
                ]);
            }


            return redirect()->back();


        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput();
        }
    }
}