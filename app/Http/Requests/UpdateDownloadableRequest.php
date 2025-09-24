<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDownloadableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:downloadables,slug,' . $this->route('downloadable'),
            'format' => 'required|string|in:pdf,epub,mp4,zip,doc,docx',
            'short_description' => 'nullable|string|max:1000',
            'long_description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,epub,mp4,zip,doc,docx|max:102400', // 100MB max
            'cover_image' => 'nullable|string|max:500',
            'download_category_id' => 'required|exists:download_categories,id',
            'user_permission' => 'required|string|in:public,visitor,user',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|string|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'format.required' => 'Le format est obligatoire.',
            'format.in' => 'Format non supportÃ©.',
            'file.mimes' => 'Format de fichier non supportÃ©.',
            'file.max' => 'Le fichier est trop volumineux (max 100MB).',
            'download_category_id.required' => 'La catÃ©gorie est obligatoire.',
            'download_category_id.exists' => 'La catÃ©gorie sÃ©lectionnÃ©e n\'existe pas.',
            'user_permission.required' => 'Les permissions sont obligatoires.',
            'user_permission.in' => 'Permission non valide.',
            'status.required' => 'Le statut est obligatoire.',
        ];
    }

    protected function prepareForValidation()
    {
        if (empty($this->slug) && !empty($this->title)) {
            $this->merge([
                'slug' => \Str::slug($this->title)
            ]);
        }

        if ($this->has('is_featured')) {
            $this->merge([
                'is_featured' => $this->boolean('is_featured')
            ]);
        } else {
            $this->merge([
                'is_featured' => false
            ]);
        }
    }
}