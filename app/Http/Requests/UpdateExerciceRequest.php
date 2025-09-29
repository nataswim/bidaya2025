<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'muscles_cibles' => 'nullable|array',
            'muscles_cibles.*' => 'string|max:50',
            'consignes_securite' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'type_exercice' => 'required|in:cardio,force,flexibilite,equilibre',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre de l\'exercice est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'niveau.required' => 'Le niveau est obligatoire.',
            'niveau.in' => 'Le niveau doit être : débutant, intermédiaire, avancé ou spécial.',
            'type_exercice.required' => 'Le type d\'exercice est obligatoire.',
            'type_exercice.in' => 'Le type doit être : cardio, force, flexibilité ou équilibre.',
            'video_url.url' => 'L\'URL de la vidéo doit être valide.',
            'muscles_cibles.*.string' => 'Chaque muscle ciblé doit être une chaîne de caractères.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'ordre' => $this->input('ordre', $this->exercice->ordre ?? 0),
        ]);
    }
}