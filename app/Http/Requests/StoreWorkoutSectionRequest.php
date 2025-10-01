<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 StoreWorkoutSectionRequest - Validation for creating a workout section
 * 🇫🇷 StoreWorkoutSectionRequest - Validation pour créer une section de workout
 * 
 * @file app/Http/Requests/StoreWorkoutSectionRequest.php
 */
class StoreWorkoutSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:workout_sections,slug',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la section est obligatoire.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true)
        ]);
    }
}