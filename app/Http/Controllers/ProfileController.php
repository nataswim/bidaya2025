<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur connecté.
     */
    public function show()
    {
        $user = Auth::user()->load('role');
        return view('profile.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'édition du profil.
     */
    public function edit()
    {
        $user = Auth::user()->load('role');
        return view('profile.edit', compact('user'));
    }

    /**
     * Met à jour le profil de l'utilisateur connecté.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        // Si le mot de passe est rempli, on le met à jour
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Supprime le compte de l'utilisateur connecté.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Votre compte a été supprimé.');
    }
}
