<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 StoreWorkoutRequest - Validation for creating a workout
 * 🇫🇷 StoreWorkoutRequest - Validation pour créer un workout
 * 
 * @file app/Http/Requests/StoreWorkoutRequest.php
 */
class StoreWorkoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:workouts,slug',
            'short_description' => 'required|string',
            'long_description' => 'nullable|string',
            'total' => 'required|integer|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:workout_categories,id',
            'order_numbers' => 'nullable|array',
            'order_numbers.*' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du workout est obligatoire.',
            'short_description.required' => 'La description courte est obligatoire.',
            'total.required' => 'Le total en mètres est obligatoire.',
            'total.integer' => 'Le total doit être un nombre entier.',
            'categories.required' => 'Sélectionnez au moins une catégorie.',
            'categories.min' => 'Sélectionnez au moins une catégorie.',
            'categories.*.exists' => 'Une des catégories sélectionnées n\'existe pas.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
        ];
    }
}