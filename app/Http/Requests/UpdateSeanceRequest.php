<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeanceRequest extends FormRequest
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
            'niveau' => 'nullable|string|max:50',
            'duree_estimee_minutes' => 'nullable|integer|min:1|max:480',
            'type_seance' => 'nullable|string|max:50',
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
            'ordre' => $this->input('ordre', $this->seance->ordre ?? 0),
        ]);
    }
}