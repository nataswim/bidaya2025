<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:videos,slug',
            'description' => 'nullable|string',
            'type' => 'required|in:upload,url,youtube,vimeo,dailymotion',
            
            // Pour les uploads
            'file' => 'nullable|required_if:type,upload|file|mimes:mp4,webm,mov,avi|max:512000', // 500MB
            
            // Pour les URLs externes
            'external_url' => 'nullable|required_if:type,url,youtube,vimeo,dailymotion|url',
            
            // Métadonnées
            'thumbnail' => 'nullable|string|max:2048',
            'duration' => 'nullable|integer|min:0',
            'width' => 'nullable|integer|min:0',
            'height' => 'nullable|integer|min:0',
            
            // Publication
            'visibility' => 'required|in:public,authenticated',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
            
            // Catégories
            'categories' => 'nullable|array',
            'categories.*' => 'exists:video_categories,id',
            
            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de la vidéo est obligatoire.',
            'type.required' => 'Le type de source est obligatoire.',
            'file.required_if' => 'Veuillez sélectionner un fichier vidéo.',
            'file.mimes' => 'Format de fichier non supporté. Formats acceptés : mp4, webm, mov, avi.',
            'file.max' => 'La taille du fichier ne doit pas dépasser 500MB.',
            'external_url.required_if' => 'L\'URL de la vidéo est obligatoire.',
            'visibility.required' => 'La visibilité est obligatoire.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('is_published')) {
            $this->merge(['is_published' => $this->boolean('is_published')]);
        } else {
            $this->merge(['is_published' => false]);
        }

        if ($this->has('is_featured')) {
            $this->merge(['is_featured' => $this->boolean('is_featured')]);
        } else {
            $this->merge(['is_featured' => false]);
        }
    }
}