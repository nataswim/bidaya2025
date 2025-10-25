<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Acces non autorise');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();

        $search = $request->input('search');
        $query = User::with('role');

        if ($search) {
            $query->where(function ($q) use ($search) {
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

        // Definir des valeurs par defaut pour les champs obligatoires
        $data = array_merge([
            'locale' => 'fr',
            'timezone' => 'Europe/Paris',
            'status' => 'active',
        ], $data);

        // Nettoyer les valeurs vides qui peuvent poser probleme
        if (empty($data['locale'])) {
            $data['locale'] = 'fr';
        }

        if (empty($data['timezone'])) {
            $data['timezone'] = 'Europe/Paris';
        }

        if (empty($data['status'])) {
            $data['status'] = 'active';
        }

        // Assigner le rôle par defaut si aucun rôle n'est specifie
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
            ->with('success', 'Utilisateur cree avec succes.');
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

        // Definir des valeurs par defaut pour les champs obligatoires
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
            ->with('success', 'Utilisateur mis A jour avec succes.');
    }

    public function destroy(User $user)
    {
        $this->checkAdminAccess();

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprime avec succes.');
    }

    /**
     * Mettre à jour le rôle d'un utilisateur via AJAX
     * 
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(Request $request, User $user)
    {
        $this->checkAdminAccess();

        // Validation
        $request->validate([
            'role_id' => 'nullable|exists:roles,id'
        ]);

        // Empêcher l'admin de changer son propre rôle
        if ($user->id === auth()->id()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas modifier votre propre rôle.'
                ], 403);
            }

            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        try {
            // Mise à jour du rôle
            $user->update([
                'role_id' => $request->role_id
            ]);

            // Charger la relation role pour la réponse
            $user->load('role');

            // Réponse selon le type de requête
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rôle mis à jour avec succès.',
                    'role' => $user->role ? [
                        'id' => $user->role->id,
                        'display_name' => $user->role->display_name,
                        'slug' => $user->role->slug
                    ] : null
                ]);
            }

            // Redirection pour les requêtes POST classiques
            return redirect()->route('admin.users.index')
                ->with('success', 'Rôle mis à jour avec succès.');
        } catch (\Exception $e) {
            // Gestion des erreurs
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la mise à jour.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }
}
