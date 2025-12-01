<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Récupérer le rôle visitor par défaut
        $visitorRole = Role::where('slug', 'visitor')
            ->where('is_default', true)
            ->first();
        
        // Fallback si pas trouvé par is_default
        if (!$visitorRole) {
            $visitorRole = Role::where('slug', 'visitor')->first();
        }

        // Sécurité : si toujours pas de rôle visitor, créer une erreur
        if (!$visitorRole) {
            Log::error('Rôle visitor non trouvé lors de l\'inscription pour: ' . $request->email);
            return redirect()->back()
                ->withErrors(['general' => 'Erreur système : configuration des rôles incomplète.'])
                ->withInput();
        }

        // Création de l'utilisateur avec tous les champs
        $user = User::create([
            // Informations de compte
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // Informations personnelles
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            
            // Coordonnées et bio
            'phone' => $request->phone,
            'bio' => $request->bio,
            
            // Configuration par défaut
            'role_id' => $visitorRole->id,
            'status' => 'active',
            'locale' => 'fr',
            'timezone' => 'Europe/Paris',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))
            ->with('success', 'Bienvenue ! Votre compte a été créé avec succès.');
    }
}