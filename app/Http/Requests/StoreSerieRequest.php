<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSerieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'exercice_id' => 'required|exists:exercices,id',
            'nom' => 'nullable|string|max:255',
            'repetitions' => 'nullable|integer|min:1|max:1000',
            'duree_secondes' => 'nullable|integer|min:1|max:86400',
            'distance_metres' => 'nullable|numeric|min:0|max:100000',
            'poids_kg' => 'nullable|numeric|min:0|max:1000',
            'repos_secondes' => 'required|integer|min:0|max:3600',
            'consignes' => 'nullable|string',
            'ordre' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'exercice_id.required' => 'L\'exercice est obligatoire.',
            'exercice_id.exists' => 'L\'exercice sélectionné n\'existe pas.',
            'repetitions.integer' => 'Le nombre de répétitions doit être un nombre entier.',
            'repetitions.min' => 'Le nombre de répétitions doit être au moins 1.',
            'repetitions.max' => 'Le nombre de répétitions ne peut pas dépasser 1000.',
            'duree_secondes.integer' => 'La durée doit être en secondes (nombre entier).',
            'duree_secondes.max' => 'La durée ne peut pas dépasser 24 heures.',
            'distance_metres.numeric' => 'La distance doit être un nombre.',
            'distance_metres.max' => 'La distance ne peut pas dépasser 100km.',
            'poids_kg.numeric' => 'Le poids doit être un nombre.',
            'poids_kg.max' => 'Le poids ne peut pas dépasser 1000kg.',
            'repos_secondes.required' => 'Le temps de repos est obligatoire.',
            'repos_secondes.max' => 'Le temps de repos ne peut pas dépasser 1 heure.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'ordre' => $this->input('ordre', 0),
            'repos_secondes' => $this->input('repos_secondes', 60),
        ]);
    }
}