<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $galleryImageId = $this->route('gallery')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'titre' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0|max:9999',
        ];

        // Règles pour l'image selon le contexte (création/modification)
        if ($isUpdate) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'; // 5MB
        } else {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120'; // 5MB
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image valide.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne doit pas dépasser 5 MB.',
            
            'alt_text.max' => 'Le texte alternatif ne peut pas dépasser 255 caractères.',
            
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre ne peut pas être négatif.',
            'ordre.max' => 'L\'ordre ne peut pas dépasser 9999.',
            
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'titre' => 'titre',
            'image' => 'image',
            'alt_text' => 'texte alternatif',
            'ordre' => 'ordre d\'affichage',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Nettoyer et formater les données avant validation
        $data = [];

        // Nettoyer le titre
        if ($this->has('titre')) {
            $data['titre'] = trim($this->titre);
        }

        // Nettoyer le texte alternatif
        if ($this->has('alt_text')) {
            $data['alt_text'] = trim($this->alt_text) ?: null;
        }

        // S'assurer que l'ordre est un entier
        if ($this->has('ordre')) {
            $data['ordre'] = $this->ordre ? (int) $this->ordre : 0;
        }


        $this->merge($data);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validation personnalisée pour l'image
            if ($this->hasFile('image')) {
                $this->validateImageDimensions($validator);
                $this->validateImageContent($validator);
            }

            // Auto-générer alt_text si vide
            if (empty($this->alt_text) && !empty($this->titre)) {
                $this->merge(['alt_text' => $this->titre]);
            }
        });
    }

    /**
     * Valider les dimensions de l'image
     */
    protected function validateImageDimensions($validator)
    {
        $image = $this->file('image');
        
        if ($image && $image->isValid()) {
            $imageInfo = getimagesize($image->getPathname());
            
            if ($imageInfo) {
                [$width, $height] = $imageInfo;
                
                // Dimensions minimales recommandées
                if ($width < 400 || $height < 300) {
                    $validator->errors()->add(
                        'image', 
                        'L\'image doit avoir une taille minimale de 400x300 pixels. Taille actuelle : ' . $width . 'x' . $height . 'px.'
                    );
                }
                
                // Ratio extrême (trop large ou trop haut)
                $ratio = $width / $height;
                if ($ratio > 5 || $ratio < 0.2) {
                    $validator->errors()->add(
                        'image', 
                        'Le ratio de l\'image est trop extrême. Utilisez une image avec un ratio plus équilibré.'
                    );
                }
            }
        }
    }

    /**
     * Valider le contenu de l'image
     */
    protected function validateImageContent($validator)
    {
        $image = $this->file('image');
        
        if ($image && $image->isValid()) {
            // Vérifier que c'est vraiment une image (pas juste l'extension)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $image->getPathname());
            finfo_close($finfo);
            
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            
            if (!in_array($mimeType, $allowedMimes)) {
                $validator->errors()->add(
                    'image', 
                    'Le fichier n\'est pas une image valide. Type détecté : ' . $mimeType
                );
            }
        }
    }
}