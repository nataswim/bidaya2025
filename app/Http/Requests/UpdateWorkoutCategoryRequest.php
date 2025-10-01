<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 🇬🇧 UpdateWorkoutCategoryRequest - Validation for updating a workout category
 * 🇫🇷 UpdateWorkoutCategoryRequest - Validation pour mettre à jour une catégorie de workout
 * 
 * @file app/Http/Requests/UpdateWorkoutCategoryRequest.php
 */
class UpdateWorkoutCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:workout_categories,slug,' . $this->workoutCategory->id,
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