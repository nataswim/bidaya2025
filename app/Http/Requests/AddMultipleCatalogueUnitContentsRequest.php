<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation pour l'ajout multiple de contenus à une unité
 * 
 * @file app/Http/Requests/AddMultipleCatalogueUnitContentsRequest.php
 */
class AddMultipleCatalogueUnitContentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contentable_type' => 'required|string|in:App\Models\Post,App\Models\Video,App\Models\Downloadable,App\Models\Fiche,App\Models\Exercice,App\Models\Workout,App\Models\EbookFile',
            'contentable_ids' => 'required|array|min:1',
            'contentable_ids.*' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'contentable_type.required' => 'Le type de contenu est obligatoire.',
            'contentable_type.in' => 'Le type de contenu sélectionné n\'est pas valide.',
            'contentable_ids.required' => 'Vous devez sélectionner au moins un contenu.',
            'contentable_ids.array' => 'Les contenus sélectionnés doivent être un tableau.',
            'contentable_ids.min' => 'Vous devez sélectionner au moins un contenu.',
            'contentable_ids.*.integer' => 'L\'ID du contenu doit être un nombre entier.',
        ];
    }
}