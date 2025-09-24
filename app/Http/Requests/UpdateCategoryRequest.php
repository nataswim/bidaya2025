<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Autorise la requête.
     */
    public function authorize(): bool
    {
        return true; // Ã adapter si tu veux restreindre l'accÃ¨s
    }

    /**
     * RÃ¨gles de validation basÃ©es sur la migration Category.
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:categories,slug,' . $this->category->id,
            'description'       => 'nullable|string',
            'group_name'        => 'nullable|string|max:255',
            'image'             => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string',
            'order'             => 'nullable|integer',
            'status'            => 'required|string|in:active,inactive',
            'created_by'        => 'nullable|integer|exists:users,id',
            'updated_by'        => 'nullable|integer|exists:users,id',
            'deleted_by'        => 'nullable|integer|exists:users,id',
        ];
    }
}
