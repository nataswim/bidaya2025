<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:permissions,name',
            'slug'        => 'required|string|max:255|unique:permissions,slug',
            'group'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
