<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:posts,slug',
            'intro'             => 'nullable|string',
            'content'           => 'required|string',
            'type'              => 'required|string|in:article,tutorial,news,review',
            'category_id'       => 'required|exists:categories,id',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
            'is_featured'       => 'nullable|boolean',
            'image'             => 'nullable|string|max:2048',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_og_image'     => 'nullable|string|max:2048',
            'meta_og_url'       => 'nullable|string|max:2048',
            'order'             => 'nullable|integer|min:0',
            'status'            => 'required|string|in:draft,published',
            'visibility'        => 'required|string|in:public,authenticated',
            'published_at'      => 'nullable|date',
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Le titre de l\'article est obligatoire.',
        'content.required' => 'Le contenu de l\'article est obligatoire.',
        'category_id.required' => 'La categorie est obligatoire.',
        'category_id.exists' => 'La categorie selectionnee n\'existe pas.',
        'status.required' => 'Le statut est obligatoire.',
        'status.in' => 'Le statut doit être "brouillon" ou "publie".',
        'visibility.required' => 'La visibilite est obligatoire.',
        'visibility.in' => 'La visibilite doit être "public" ou "authenticated".',
        'type.required' => 'Le type d\'article est obligatoire.',
        'type.in' => 'Le type d\'article n\'est pas valide.',
        'tags.*.exists' => 'Un ou plusieurs tags selectionnes n\'existent pas.',
        'image.string' => 'L\'image doit être une chaîne de caracteres valide.', // ← CHANGe
        'meta_og_image.string' => 'L\'image Open Graph doit être une chaîne de caracteres valide.', // ← CHANGe
        'meta_og_url.string' => 'L\'URL Open Graph doit être une chaîne de caracteres valide.', // ← CHANGe
    ];
}

    protected function prepareForValidation()
    {
        // Convertir is_featured en boolean
        if ($this->has('is_featured')) {
            $this->merge([
                'is_featured' => $this->boolean('is_featured')
            ]);
        } else {
            $this->merge([
                'is_featured' => false
            ]);
        }

        // S'assurer que visibility a une valeur par defaut
        if (!$this->has('visibility') || empty($this->visibility)) {
            $this->merge([
                'visibility' => 'public'
            ]);
        }
    }
}