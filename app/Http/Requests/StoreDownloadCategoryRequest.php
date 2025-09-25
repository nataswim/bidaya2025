<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDownloadCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:download_categories,slug',
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
            'name.required' => 'Le nom de la categorie est obligatoire.',
            'slug.unique' => 'Ce slug est dejÃ utilise.',
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