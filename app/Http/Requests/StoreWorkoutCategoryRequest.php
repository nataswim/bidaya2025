<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 StoreWorkoutCategoryRequest - Validation for creating a workout category
 * 🇫🇷 StoreWorkoutCategoryRequest - Validation pour créer une catégorie de workout
 * 
 * @file app/Http/Requests/StoreWorkoutCategoryRequest.php
 */
class StoreWorkoutCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:workout_categories,slug',
            'description' => 'nullable|string',
            'workout_section_id' => 'required|exists:workout_sections,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'workout_section_id.required' => 'La section est obligatoire.',
            'workout_section_id.exists' => 'La section sélectionnée n\'existe pas.',
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