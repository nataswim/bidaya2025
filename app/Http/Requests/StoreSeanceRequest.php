<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeanceRequest extends FormRequest
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
            'duree_estimee_minutes' => 'nullable|integer|min:1|max:480',
            'type_seance' => 'required|in:force,cardio,mixte,recuperation',
            'materiel_requis' => 'nullable|string',
            'echauffement' => 'nullable|string',
            'retour_calme' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'series' => 'nullable|array',
            'series.*.serie_id' => 'required_with:series|exists:series,id',
            'series.*.ordre' => 'required_with:series|integer|min:1',
            'series.*.nombre_series' => 'required_with:series|integer|min:1|max:10',
            'series.*.notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre de la séance est obligatoire.',
            'niveau.required' => 'Le niveau est obligatoire.',
            'niveau.in' => 'Le niveau doit être : débutant, intermédiaire, avancé ou spécial.',
            'type_seance.required' => 'Le type de séance est obligatoire.',
            'type_seance.in' => 'Le type doit être : force, cardio, mixte ou récupération.',
            'duree_estimee_minutes.max' => 'La durée ne peut pas dépasser 8 heures.',
            'series.*.serie_id.required_with' => 'La série est obligatoire.',
            'series.*.serie_id.exists' => 'Une série sélectionnée n\'existe pas.',
            'series.*.ordre.required_with' => 'L\'ordre de la série est obligatoire.',
            'series.*.nombre_series.required_with' => 'Le nombre de séries est obligatoire.',
            'series.*.nombre_series.max' => 'Le nombre de séries ne peut pas dépasser 10.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'ordre' => $this->input('ordre', 0),
        ]);
    }
}