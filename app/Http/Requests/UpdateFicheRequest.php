<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 UpdateFicheRequest - Validation for updating a fiche
 * 🇫🇷 UpdateFicheRequest - Validation pour mettre à jour une fiche
 * 
 * @file app/Http/Requests/UpdateFicheRequest.php
 */
class UpdateFicheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    return [
        'title' => 'required|string|max:191',
        'slug' => 'nullable|string|max:191|unique:fiches,slug,' . $this->fiche->id,
        'short_description' => 'required|string',
        'long_description' => 'nullable|string',
        'image' => 'nullable|string|max:2048',
        'visibility' => 'required|string|in:public,authenticated',
        'is_published' => 'nullable|boolean',
        'is_featured' => 'nullable|boolean',
        'sort_order' => 'nullable|integer|min:0',
        'fiches_category_id' => 'nullable|exists:fiches_categories,id', // ← MODIFIÉ : nullable
        'fiches_sous_category_id' => 'nullable|exists:fiches_sous_categories,id', // ← NOUVEAU
        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_og_image' => 'nullable|string|max:2048',
        'meta_og_url' => 'nullable|string|max:2048',
        'published_at' => 'nullable|date',
    ];
}

// 🇬🇧 Add custom validation / 🇫🇷 Ajouter une validation personnalisée
public function withValidator($validator)
{
    $validator->after(function ($validator) {
        // 🇬🇧 At least one category or sub-category required / 🇫🇷 Au moins une catégorie ou sous-catégorie requise
        if (!$this->fiches_category_id && !$this->fiches_sous_category_id) {
            $validator->errors()->add('fiches_category_id', 'Une catégorie ou une sous-catégorie est obligatoire.');
        }
    });
}
   public function messages(): array
{
    return [
        'title.required' => 'Le titre de la fiche est obligatoire.',
        'short_description.required' => 'La description courte est obligatoire.',
        'visibility.required' => 'La visibilité est obligatoire.',
        'visibility.in' => 'La visibilité doit être "public" ou "authenticated".',
        'fiches_category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
        'fiches_sous_category_id.exists' => 'La sous-catégorie sélectionnée n\'existe pas.',
    ];
}

    protected function prepareForValidation()
    {
        // 🇬🇧 Convert is_featured to boolean / 🇫🇷 Convertir is_featured en boolean
        if ($this->has('is_featured')) {
            $this->merge([
                'is_featured' => $this->boolean('is_featured')
            ]);
        } else {
            $this->merge([
                'is_featured' => false
            ]);
        }

        // 🇬🇧 Convert is_published to boolean / 🇫🇷 Convertir is_published en boolean
        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => $this->boolean('is_published')
            ]);
        }

        // 🇬🇧 Ensure visibility is properly set / 🇫🇷 S'assurer que visibility est bien définie
        if (!$this->has('visibility') || empty($this->visibility)) {
            $this->merge([
                'visibility' => 'public'
            ]);
        }
    }
}