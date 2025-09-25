<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1'],
            'files.*' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:5120', // 5MB en KB
            ],
            'media_category_id' => ['nullable', 'exists:media_categories,id'],
            'names' => ['nullable', 'array'],
            'names.*' => ['nullable', 'string', 'max:255'],
            'alt_texts' => ['nullable', 'array'],
            'alt_texts.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Veuillez selectionner au moins un fichier.',
            'files.*.image' => 'Le fichier doit être une image.',
            'files.*.mimes' => 'Formats acceptes : JPEG, PNG, GIF, WebP.',
            'files.*.max' => 'La taille maximum autorisee est de 5MB.',
            'media_category_id.exists' => 'La categorie selectionnee n\'existe pas.',
        ];
    }
}