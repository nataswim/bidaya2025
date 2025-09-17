<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:tags,name,' . $this->tag->id,
            'slug'        => 'nullable|string|max:255|unique:tags,slug,' . $this->tag->id,
            'description' => 'nullable|string',
        ];
    }
}
