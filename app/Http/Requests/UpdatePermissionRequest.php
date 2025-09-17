<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:permissions,name,' . $this->permission->id,
            'slug'        => 'required|string|max:255|unique:permissions,slug,' . $this->permission->id,
            'group'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
