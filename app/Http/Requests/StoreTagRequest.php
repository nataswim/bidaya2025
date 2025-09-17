<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:tags,name',
            'slug'        => 'nullable|string|max:255|unique:tags,slug',
            'description' => 'nullable|string',
        ];
    }
}
