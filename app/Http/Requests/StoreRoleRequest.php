<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255|unique:roles,name',
            'slug'         => 'required|string|max:255|unique:roles,slug',
            'display_name' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'level'        => 'nullable|integer',
            'is_default'   => 'boolean',
            'permissions'  => 'nullable|array',
            'permissions.*'=> 'exists:permissions,id',
        ];
    }
}
