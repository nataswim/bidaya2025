<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 UpdateCatalogueUnitRequest - Validation for updating a catalogue unit
 * 🇫🇷 UpdateCatalogueUnitRequest - Validation pour mettre à jour une unité de catalogue
 * 
 * @file app/Http/Requests/UpdateCatalogueUnitRequest.php
 */
class UpdateCatalogueUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'catalogue_module_id' => 'required|exists:catalogue_modules,id',
            'unitable_type' => 'nullable|string|in:App\Models\Post,App\Models\Video,App\Models\Downloadable,App\Models\Fiche,App\Models\Exercice,App\Models\Workout,App\Models\EbookFile',
            'unitable_id' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'unité est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 191 caractères.',
            'catalogue_module_id.required' => 'Le module parent est obligatoire.',
            'catalogue_module_id.exists' => 'Le module sélectionné n\'existe pas.',
            'unitable_type.in' => 'Le type de contenu sélectionné n\'est pas valide.',
            'unitable_id.integer' => 'L\'ID du contenu doit être un nombre entier.',
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