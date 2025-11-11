<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 StoreCatalogueSectionRequest - Validation for creating a catalogue section
 * 🇫🇷 StoreCatalogueSectionRequest - Validation pour créer une section de catalogue
 * 
 * @file app/Http/Requests/StoreCatalogueSectionRequest.php
 */
class StoreCatalogueSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:catalogue_sections,slug',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la section est obligatoire.',
            'name.max' => 'Le nom ne peut pas dépasser 191 caractères.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'image.string' => 'L\'image doit être une chaîne de caractères valide.',
            'order.integer' => 'L\'ordre doit être un nombre entier.',
            'order.min' => 'L\'ordre doit être supérieur ou égal à 0.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => $this->boolean('is_active')
            ]);
        } else {
            $this->merge([
                'is_active' => true
            ]);
        }
    }
}