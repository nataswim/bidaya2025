<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 UpdateCatalogueModuleRequest - Validation for updating a catalogue module
 * 🇫🇷 UpdateCatalogueModuleRequest - Validation pour mettre à jour un module de catalogue
 * 
 * @file app/Http/Requests/UpdateCatalogueModuleRequest.php
 */
class UpdateCatalogueModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'catalogue_section_id' => 'required|exists:catalogue_sections,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du module est obligatoire.',
            'name.max' => 'Le nom ne peut pas dépasser 191 caractères.',
            'catalogue_section_id.required' => 'La section parente est obligatoire.',
            'catalogue_section_id.exists' => 'La section sélectionnée n\'existe pas.',
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
        }
    }
}