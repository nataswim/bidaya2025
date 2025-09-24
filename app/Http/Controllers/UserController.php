<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'AccÃ¨s non autorisÃ©');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $query = User::with('role');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
{
    $this->checkAdminAccess();
    
    $data = $request->validated();
    $data['password'] = Hash::make($data['password']);

    // DÃ©finir des valeurs par dÃ©faut pour les champs obligatoires
    $data = array_merge([
        'locale' => 'fr',
        'timezone' => 'Europe/Paris',
        'status' => 'active',
    ], $data);

    // Nettoyer les valeurs vides qui peuvent poser problÃ¨me
    if (empty($data['locale'])) {
        $data['locale'] = 'fr';
    }
    
    if (empty($data['timezone'])) {
        $data['timezone'] = 'Europe/Paris';
    }
    
    if (empty($data['status'])) {
        $data['status'] = 'active';
    }

    // Assigner le rôle par dÃ©faut si aucun rôle n'est spÃ©cifiÃ©
    if (empty($data['role_id'])) {
        $defaultRole = Role::where('is_default', true)->first();
        $data['role_id'] = $defaultRole?->id;
    }

    // Nettoyer les champs optionnels vides
    $optionalFields = ['username', 'first_name', 'last_name', 'avatar', 'bio', 'phone', 'date_of_birth'];
    foreach ($optionalFields as $field) {
        if (isset($data[$field]) && empty($data[$field])) {
            $data[$field] = null;
        }
    }

    User::create($data);

    return redirect()->route('admin.users.index')
        ->with('success', 'Utilisateur crÃ©Ã© avec succÃ¨s.');
}



    public function show(User $user)
    {
        $this->checkAdminAccess();
        
        $user->load('role');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->checkAdminAccess();
        
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
{
    $this->checkAdminAccess();
    
    $data = $request->validated();

    // Gestion du mot de passe
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    // DÃ©finir des valeurs par dÃ©faut pour les champs obligatoires
    if (empty($data['locale'])) {
        $data['locale'] = 'fr';
    }
    
    if (empty($data['timezone'])) {
        $data['timezone'] = 'Europe/Paris';
    }
    
    if (empty($data['status'])) {
        $data['status'] = 'active';
    }

    // Nettoyer les champs optionnels vides
    $optionalFields = ['username', 'first_name', 'last_name', 'avatar', 'bio', 'phone', 'date_of_birth'];
    foreach ($optionalFields as $field) {
        if (isset($data[$field]) && empty($data[$field])) {
            $data[$field] = null;
        }
    }

    $user->update($data);

    return redirect()->route('admin.users.index')
        ->with('success', 'Utilisateur mis Ã jour avec succÃ¨s.');
}

    public function destroy(User $user)
    {
        $this->checkAdminAccess();
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimÃ© avec succÃ¨s.');
    }
}