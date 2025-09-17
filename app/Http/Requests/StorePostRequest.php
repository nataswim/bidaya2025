<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'               => 'required|string|max:255|unique:posts,name',
            'slug'               => 'nullable|string|max:255|unique:posts,slug',
            'intro'              => 'nullable|string',
            'content'            => 'nullable|string',
            'type'               => 'nullable|string|max:50',
            'category_id'        => 'required|exists:categories,id',
            'category_name'      => 'nullable|string|max:255',
            'is_featured'        => 'boolean',
            'image'              => 'nullable|string|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_keywords'      => 'nullable|string',
            'meta_description'   => 'nullable|string',
            'meta_og_image'      => 'nullable|string|max:255',
            'meta_og_url'        => 'nullable|string|max:255',
            'hits'               => 'nullable|integer',
            'order'              => 'nullable|integer',
            'status'             => 'required|string|in:draft,published',
            'moderated_by'       => 'nullable|integer|exists:users,id',
            'moderated_at'       => 'nullable|date',
            'created_by'         => 'nullable|integer|exists:users,id',
            'created_by_name'    => 'nullable|string|max:255',
            'created_by_alias'   => 'nullable|string|max:255',
            'updated_by'         => 'nullable|integer|exists:users,id',
            'deleted_by'         => 'nullable|integer|exists:users,id',
            'published_at'       => 'nullable|date',
            'tags'               => 'nullable|array',
            'tags.*'             => 'exists:tags,id',
        ];
    }
}
