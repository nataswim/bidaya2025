<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'duree_semaines' => 'nullable|integer|min:1|max:104',
            'objectif' => 'required|in:force,endurance,perte_poids,prise_masse,recuperation,mixte',
            'prerequis' => 'nullable|string',
            'conseils_generaux' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'cycles' => 'nullable|array',
            'cycles.*.cycle_id' => 'required_with:cycles|exists:cycles,id',
            'cycles.*.ordre' => 'required_with:cycles|integer|min:1',
            'cycles.*.semaine_debut' => 'required_with:cycles|integer|min:1|max:104',
            'cycles.*.notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre du plan est obligatoire.',
            'niveau.required' => 'Le niveau est obligatoire.',
            'niveau.in' => 'Le niveau doit être : débutant, intermédiaire, avancé ou spécial.',
            'objectif.required' => 'L\'objectif est obligatoire.',
            'objectif.in' => 'L\'objectif doit être : force, endurance, perte de poids, prise de masse, récupération ou mixte.',
            'duree_semaines.max' => 'La durée ne peut pas dépasser 2 ans.',
            'cycles.*.cycle_id.required_with' => 'Le cycle est obligatoire.',
            'cycles.*.cycle_id.exists' => 'Un cycle sélectionné n\'existe pas.',
            'cycles.*.ordre.required_with' => 'L\'ordre du cycle est obligatoire.',
            'cycles.*.semaine_debut.required_with' => 'La semaine de début est obligatoire.',
            'cycles.*.semaine_debut.max' => 'La semaine de début ne peut pas dépasser 104.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_public' => $this->boolean('is_public'),
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'ordre' => $this->input('ordre', 0),
        ]);
    }
}