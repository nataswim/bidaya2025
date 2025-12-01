<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // ← Ajouter cet import
use Illuminate\Validation\Rules;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Recuperer le rôle visitor par defaut
        $visitorRole = Role::where('name', 'visitor')->where('is_default', true)->first();
        
        // Fallback si pas trouve par is_default
        if (!$visitorRole) {
            $visitorRole = Role::where('name', 'visitor')->first();
        }

        // Securite : si toujours pas de rôle visitor, creer une erreur
        if (!$visitorRole) {
            Log::error('Rôle visitor non trouve lors de l\'inscription pour: ' . $request->email);
            return redirect()->back()
                ->withErrors(['general' => 'Erreur systeme : configuration des rôles incomplete.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $visitorRole->id, // Assigner automatiquement le rôle visitor
            'status' => 'active',
            'locale' => 'fr',
            'timezone' => 'Europe/Paris',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))
            ->with('success', 'Inscription reussie ! Votre compte doit être valide par un administrateur pour acceder aux contenus premium.');
    }
}