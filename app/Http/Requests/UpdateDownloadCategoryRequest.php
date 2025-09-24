<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDownloadCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Récupération sécurisée de l'ID de la catégorie
        $categoryId = null;
        
        try {
            // Première tentative avec camelCase
            if ($this->route()->hasParameter('downloadCategory')) {
                $category = $this->route('downloadCategory');
                $categoryId = is_object($category) ? $category->id : $category;
            }
            // Deuxième tentative avec snake_case
            elseif ($this->route()->hasParameter('download_category')) {
                $category = $this->route('download_category');
                $categoryId = is_object($category) ? $category->id : $category;
            }
        } catch (\Exception $e) {
            // En cas d'erreur, on laisse null pour éviter le crash
            $categoryId = null;
        }
        
        return [
            'name' => 'required|string|max:200',
            'slug' => $categoryId 
                ? 'nullable|string|max:200|unique:download_categories,slug,' . $categoryId
                : 'nullable|string|max:200',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|string|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut doit être "active" ou "inactive".',
        ];
    }

    protected function prepareForValidation()
    {
        if (empty($this->slug) && !empty($this->name)) {
            $this->merge([
                'slug' => \Str::slug($this->name)
            ]);
        }
    }
}