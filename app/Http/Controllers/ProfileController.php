<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function show()
    {
        $this->checkAdminAccess();
        
        $user = Auth::user()->load('role');
        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $this->checkAdminAccess();
        
        $user = Auth::user()->load('role');
        return view('admin.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->checkAdminAccess();
        
        $user = Auth::user();
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy(Request $request)
    {
        $this->checkAdminAccess();
        
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Votre compte a été supprimé.');
    }
}