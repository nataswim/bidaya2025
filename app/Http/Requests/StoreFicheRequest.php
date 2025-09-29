<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 StoreFicheRequest - Validation for creating a fiche
 * 🇫🇷 StoreFicheRequest - Validation pour créer une fiche
 * 
 * @file app/Http/Requests/StoreFicheRequest.php
 */
class StoreFicheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:fiches,slug',
            'short_description' => 'required|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'visibility' => 'required|string|in:public,authenticated',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_og_image' => 'nullable|string|max:2048',
            'meta_og_url' => 'nullable|string|max:2048',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:fiches_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de la fiche est obligatoire.',
            'short_description.required' => 'La description courte est obligatoire.',
            'visibility.required' => 'La visibilité est obligatoire.',
            'visibility.in' => 'La visibilité doit être "public" ou "authenticated".',
            'categories.*.exists' => 'Une ou plusieurs catégories sélectionnées n\'existent pas.',
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

        // 🇬🇧 Ensure visibility has default value / 🇫🇷 S'assurer que visibility a une valeur par défaut
        if (!$this->has('visibility') || empty($this->visibility)) {
            $this->merge([
                'visibility' => 'public'
            ]);
        }
    }
}