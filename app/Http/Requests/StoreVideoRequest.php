<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation pour la création d'une vidéo
 * 
 * @file app/Http/Requests/StoreVideoRequest.php
 */
class StoreVideoRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:videos,slug',
            'description' => 'nullable|string',
            'type' => 'required|in:upload,url,youtube,vimeo,dailymotion',
            
            // Métadonnées
            'thumbnail' => 'nullable|string|max:2048',
            'duration' => 'nullable|integer|min:0',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            
            // Publication
            'visibility' => 'required|in:public,authenticated',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
            
            // Catégories
            'categories' => 'nullable|array',
            'categories.*' => 'exists:video_categories,id',
            
            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // Règles conditionnelles selon le type
        if ($this->input('type') === 'upload') {
            // Si on utilise la bibliothèque
            if ($this->filled('library_file_path')) {
                $rules['library_file_path'] = 'required|string';
                $rules['library_file_size'] = 'required|string';
                $rules['library_mime_type'] = 'required|string';
            } 
            // Sinon, on exige un fichier uploadé
            else {
                $rules['file'] = 'required|file|mimes:mp4,webm,mov,avi,mkv,flv,wmv,mpeg,mpg,3gp|max:512000'; // 500MB
            }
        } 
        // Pour les URLs externes
        elseif (in_array($this->input('type'), ['url', 'youtube', 'vimeo', 'dailymotion'])) {
            $rules['external_url'] = 'required|url';
        }

        return $rules;
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de la vidéo est obligatoire.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé par une autre vidéo.',
            'type.required' => 'Le type de source est obligatoire.',
            'type.in' => 'Le type de source sélectionné n\'est pas valide.',
            
            // Messages pour upload fichier
            'file.required' => 'Veuillez sélectionner un fichier vidéo ou choisir une vidéo depuis la bibliothèque.',
            'file.file' => 'Le fichier uploadé n\'est pas valide.',
            'file.mimes' => 'Format de fichier non supporté. Formats acceptés : mp4, webm, mov, avi, mkv, flv, wmv, mpeg, mpg, 3gp.',
            'file.max' => 'La taille du fichier ne doit pas dépasser 500 Mo.',
            
            // Messages pour bibliothèque
            'library_file_path.required' => 'Le chemin du fichier de la bibliothèque est requis.',
            'library_file_size.required' => 'La taille du fichier de la bibliothèque est requise.',
            'library_mime_type.required' => 'Le type MIME du fichier de la bibliothèque est requis.',
            
            // Messages pour URL externe
            'external_url.required' => 'L\'URL de la vidéo est obligatoire.',
            'external_url.url' => 'L\'URL de la vidéo doit être une URL valide.',
            
            // Messages pour visibilité
            'visibility.required' => 'La visibilité est obligatoire.',
            'visibility.in' => 'La visibilité sélectionnée n\'est pas valide.',
            
            // Messages pour catégories
            'categories.array' => 'Les catégories doivent être un tableau.',
            'categories.*.exists' => 'Une ou plusieurs catégories sélectionnées n\'existent pas.',
            
            // Messages pour SEO
            'meta_title.max' => 'Le titre SEO ne doit pas dépasser 255 caractères.',
            'meta_keywords.max' => 'Les mots-clés ne doivent pas dépasser 255 caractères.',
            'meta_description.max' => 'La description SEO ne doit pas dépasser 500 caractères.',
        ];
    }

    /**
     * Préparer les données pour la validation
     */
    protected function prepareForValidation()
    {
        // Convertir les checkboxes en booléens
        if ($this->has('is_published')) {
            $this->merge(['is_published' => $this->boolean('is_published')]);
        } else {
            $this->merge(['is_published' => false]);
        }

        if ($this->has('is_featured')) {
            $this->merge(['is_featured' => $this->boolean('is_featured')]);
        } else {
            $this->merge(['is_featured' => false]);
        }
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'title' => 'titre',
            'slug' => 'slug',
            'description' => 'description',
            'type' => 'type de source',
            'file' => 'fichier vidéo',
            'external_url' => 'URL de la vidéo',
            'thumbnail' => 'miniature',
            'duration' => 'durée',
            'width' => 'largeur',
            'height' => 'hauteur',
            'visibility' => 'visibilité',
            'is_published' => 'statut de publication',
            'is_featured' => 'vidéo en vedette',
            'sort_order' => 'ordre d\'affichage',
            'published_at' => 'date de publication',
            'categories' => 'catégories',
            'meta_title' => 'titre SEO',
            'meta_keywords' => 'mots-clés',
            'meta_description' => 'description SEO',
            'library_file_path' => 'chemin du fichier bibliothèque',
            'library_file_size' => 'taille du fichier bibliothèque',
            'library_mime_type' => 'type MIME bibliothèque',
        ];
    }
}