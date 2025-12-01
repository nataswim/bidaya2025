<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Étape 1 : Informations de compte
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Étape 2 : Informations personnelles (OBLIGATOIRES)
            'username' => ['required', 'string', 'max:60', 'unique:users,username', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date', 'before:-17 years'],
            
            // Étape 3 : Coordonnées et bio (OBLIGATOIRES)
            'phone' => ['required', 'string', 'regex:/^(\+33|0)[1-9](\d{2}){4}$/'],
            'bio' => ['required', 'string', 'max:200'],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'username.regex' => 'Le nom d\'utilisateur ne peut contenir que des lettres, chiffres, tirets et underscores.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'date_of_birth.before' => 'Vous devez avoir au moins 17 ans pour vous inscrire.',
            'phone.regex' => 'Le numéro de téléphone doit être au format français valide (ex: 0612345678 ou +33612345678).',
            'bio.max' => 'La biographie ne peut pas dépasser 200 caractères.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom complet',
            'email' => 'adresse email',
            'password' => 'mot de passe',
            'username' => 'nom d\'utilisateur',
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'date_of_birth' => 'date de naissance',
            'phone' => 'téléphone',
            'bio' => 'biographie',
        ];
    }
}