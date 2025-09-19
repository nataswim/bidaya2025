<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
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
        $query = Role::with('permissions');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->orderBy('level', 'asc')->paginate(10);

        return view('admin.roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->checkAdminAccess();
        
        $role = Role::create($request->validated());

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->input('permissions'));
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function show(Role $role)
    {
        $this->checkAdminAccess();
        
        $role->load(['permissions', 'users']);
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->checkAdminAccess();
        
        $permissions = Permission::all()->groupBy('group');
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->checkAdminAccess();
        
        $role->update($request->validated());

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->input('permissions'));
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role)
    {
        $this->checkAdminAccess();
        
        // Vérifier les dépendances avec les utilisateurs
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Impossible de supprimer un rôle assigné à des utilisateurs.');
        }
        
        // Empêcher la suppression du rôle par défaut
        if ($role->is_default) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Impossible de supprimer le rôle par défaut.');
        }
        
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }
}