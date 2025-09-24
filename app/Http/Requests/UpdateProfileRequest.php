<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser l'utilisateur connectÃ©
    }

    public function rules(): array
    {
        return [
            'username'          => 'nullable|string|max:255|unique:users,username,' . $this->user()->id,
            'first_name'        => 'nullable|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'name'              => 'nullable|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'password'          => 'nullable|string|min:8|confirmed',
            'avatar'            => 'nullable|string|max:255',
            'bio'               => 'nullable|string',
            'phone'             => 'nullable|string|max:50',
            'date_of_birth'     => 'nullable|date',
            'locale'            => 'nullable|string|max:10',
            'timezone'          => 'nullable|string|max:50',
        ];
    }
}
