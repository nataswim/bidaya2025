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

        // RÃ©cupÃ©rer le rôle visitor par dÃ©faut
        $visitorRole = Role::where('name', 'visitor')->where('is_default', true)->first();
        
        // Fallback si pas trouvÃ© par is_default
        if (!$visitorRole) {
            $visitorRole = Role::where('name', 'visitor')->first();
        }

        // SÃ©curitÃ© : si toujours pas de rôle visitor, crÃ©er une erreur
        if (!$visitorRole) {
            Log::error('Rôle visitor non trouvÃ© lors de l\'inscription pour: ' . $request->email);
            return redirect()->back()
                ->withErrors(['general' => 'Erreur systÃ¨me : configuration des rôles incomplÃ¨te.'])
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
            ->with('success', 'Inscription rÃ©ussie ! Votre compte doit être validÃ© par un administrateur pour accÃ©der aux contenus premium.');
    }
}