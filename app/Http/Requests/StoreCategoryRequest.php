<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser tous les utilisateurs pour l'instant
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255|unique:categories,name',
            'slug'              => 'nullable|string|max:255|unique:categories,slug',
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
