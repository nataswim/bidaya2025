<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:videos,slug,' . $this->video->id,
            'description' => 'nullable|string',
            'type' => 'required|in:upload,url,youtube,vimeo,dailymotion',
            
            // Pour les uploads
            'file' => 'nullable|file|mimes:mp4,webm,mov,avi|max:512000',
            
            // Pour les URLs externes
            'external_url' => 'nullable|url',
            
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

    protected function prepareForValidation()
    {
        if ($this->has('is_published')) {
            $this->merge(['is_published' => $this->boolean('is_published')]);
        }

        if ($this->has('is_featured')) {
            $this->merge(['is_featured' => $this->boolean('is_featured')]);
        }
    }
}