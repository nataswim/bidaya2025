<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
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
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.permissions.index', compact('permissions', 'search'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $this->checkAdminAccess();
        
        Permission::create($request->validated());

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission crÃ©Ã©e avec succÃ¨s.');
    }

    public function show(Permission $permission)
    {
        $this->checkAdminAccess();
        
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $this->checkAdminAccess();
        
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->checkAdminAccess();
        
        $permission->update($request->validated());

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission mise Ã jour avec succÃ¨s.');
    }

    public function destroy(Permission $permission)
    {
        $this->checkAdminAccess();
        
        // VÃ©rifier les dÃ©pendances avec les rôles
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Impossible de supprimer une permission assignÃ©e Ã des rôles.');
        }
        
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission supprimÃ©e avec succÃ¨s.');
    }
}