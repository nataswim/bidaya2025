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
            abort(403, 'Accès non autorisé');
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

        if (!isset($data['role_id'])) {
            $defaultRole = Role::where('is_default', true)->first();
            $data['role_id'] = $defaultRole?->id;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
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

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $this->checkAdminAccess();
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}