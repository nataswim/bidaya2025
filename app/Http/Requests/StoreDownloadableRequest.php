<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDownloadableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'title' => 'required|string|max:200',
        'slug' => 'nullable|string|max:200|unique:downloadables,slug',
        'format' => 'required|string|in:pdf,epub,mp4,zip,doc,docx',
        'short_description' => 'nullable|string|max:1000',
        'long_description' => 'nullable|string',
        
        // Source du fichier
        'file_source' => 'required|in:upload,existing',
        'file' => 'required_if:file_source,upload|nullable|file|mimes:pdf,epub,mp4,zip,doc,docx|max:204800',
        'ebook_file_id' => 'required_if:file_source,existing|nullable|exists:ebook_files,id',
        
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
        'format.in' => 'Format non supporté.',
        'file_source.required' => 'Veuillez choisir une source de fichier.',
        'file.required_if' => 'Le fichier est obligatoire si vous choisissez "Télécharger nouveau".',
        'ebook_file_id.required_if' => 'Veuillez sélectionner un fichier existant.',
        'file.mimes' => 'Format de fichier non supporté.',
        'file.max' => 'Le fichier est trop volumineux (max 200MB).',
        'download_category_id.required' => 'La catégorie est obligatoire.',
        'download_category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
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