<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Cycle;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request): View
{
    $this->checkAdminAccess();
    
    $search = $request->input('search');
    
    $query = Plan::with(['creator'])->withCount(['users', 'cycles']);

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $plans = $query->ordered()->paginate(15);

    return view('admin.training.plans.index', compact('plans', 'search'));
}

    public function create(): View
    {
        $this->checkAdminAccess();
        $cycles = Cycle::active()->ordered()->get();
        return view('admin.training.plans.create', compact('cycles'));
    }




public function store(Request $request): RedirectResponse
{
    $this->checkAdminAccess();
    
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'niveau' => 'nullable|string|max:50',
        'duree_semaines' => 'nullable|integer|min:1|max:104',
        'objectif' => 'nullable|string|max:50',
        'prerequis' => 'nullable|string',
        'conseils_generaux' => 'nullable|string',
        'image' => 'nullable|string|max:500',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'ordre' => 'nullable|integer|min:0',
        'cycles' => 'nullable|array',
        'cycles.*.cycle_id' => 'required_with:cycles|exists:cycles,id',
        'cycles.*.ordre' => 'required_with:cycles|integer|min:1',
        'cycles.*.semaine_debut' => 'required_with:cycles|integer|min:1|max:104',
        'cycles.*.notes' => 'nullable|string|max:500',
    ]);

    $validated['is_public'] = $request->boolean('is_public');
    $validated['is_featured'] = $request->boolean('is_featured');
    $validated['is_active'] = $request->boolean('is_active');
    $validated['ordre'] = $validated['ordre'] ?? 0;

    $plan = Plan::create($validated);

    // Attacher les cycles
    if (!empty($validated['cycles'])) {
        foreach ($validated['cycles'] as $cycle) {
            $plan->cycles()->attach($cycle['cycle_id'], [
                'ordre' => $cycle['ordre'],
                'semaine_debut' => $cycle['semaine_debut'],
                'notes' => $cycle['notes'] ?? null,
            ]);
        }
    }

    return redirect()->route('admin.training.plans.index')
        ->with('success', 'Plan créé avec succès.');
}

public function update(Request $request, Plan $plan): RedirectResponse
{
    $this->checkAdminAccess();
    
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'niveau' => 'nullable|string|max:50',
        'duree_semaines' => 'nullable|integer|min:1|max:104',
        'objectif' => 'nullable|string|max:50',
        'prerequis' => 'nullable|string',
        'conseils_generaux' => 'nullable|string',
        'image' => 'nullable|string|max:500',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'ordre' => 'nullable|integer|min:0',
        'cycles' => 'nullable|array',
        'cycles.*.cycle_id' => 'required_with:cycles|exists:cycles,id',
        'cycles.*.ordre' => 'required_with:cycles|integer|min:1',
        'cycles.*.semaine_debut' => 'required_with:cycles|integer|min:1|max:104',
        'cycles.*.notes' => 'nullable|string|max:500',
    ]);

    $validated['is_public'] = $request->boolean('is_public');
    $validated['is_featured'] = $request->boolean('is_featured');
    $validated['is_active'] = $request->boolean('is_active');
    $validated['ordre'] = $validated['ordre'] ?? $plan->ordre;

    $plan->update($validated);

    // Resynchroniser les cycles
    $plan->cycles()->detach();
    if (!empty($validated['cycles'])) {
        foreach ($validated['cycles'] as $cycle) {
            $plan->cycles()->attach($cycle['cycle_id'], [
                'ordre' => $cycle['ordre'],
                'semaine_debut' => $cycle['semaine_debut'],
                'notes' => $cycle['notes'] ?? null,
            ]);
        }
    }

    return redirect()->route('admin.training.plans.index')
        ->with('success', 'Plan mis à jour avec succès.');
}




    public function show(Plan $plan): View
    {
        $this->checkAdminAccess();
        $plan->load(['creator', 'cycles.seances.series.exercice', 'users']);
        return view('admin.training.plans.show', compact('plan'));
    }

    public function edit(Plan $plan): View
    {
        $this->checkAdminAccess();
        $plan->load(['cycles']);
        $cycles = Cycle::active()->ordered()->get();
        return view('admin.training.plans.edit', compact('plan', 'cycles'));
    }








    
    

    public function destroy(Plan $plan): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si le plan a des utilisateurs assignés
        if ($plan->users()->count() > 0) {
            return redirect()->route('admin.training.plans.index')
                ->with('error', 'Impossible de supprimer un plan assigné à des utilisateurs.');
        }

        $plan->cycles()->detach();
        $plan->delete();

        return redirect()->route('admin.training.plans.index')
            ->with('success', 'Plan supprimé avec succès.');
    }

    // Gestion des assignations
    public function assignations(Plan $plan): View
    {
        $this->checkAdminAccess();
        
        $plan->load(['users' => function($query) {
            $query->withPivot('date_debut', 'date_fin_prevue', 'statut', 'progression_pourcentage', 'assigned_by')
                  ->with('role');
        }]);
        
        $users = User::whereHas('role', function($query) {
            $query->where('slug', 'user');
        })->where('status', 'active')->orderBy('name')->get();

        return view('admin.training.plans.assignations', compact('plan', 'users'));
    }

    public function assignUser(Request $request, Plan $plan): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_debut' => 'nullable|date|after_or_equal:today',
            'notes_admin' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        // Vérifier que l'utilisateur peut accéder aux plans
        if (!$user->canAccessTraining()) {
            return redirect()->back()
                ->with('error', 'Cet utilisateur ne peut pas accéder aux plans d\'entraînement.');
        }

        // Vérifier si déjà assigné
        if ($plan->isAssignedToUser($user->id)) {
            return redirect()->back()
                ->with('error', 'Ce plan est déjà assigné à cet utilisateur.');
        }

        $dateDebut = $validated['date_debut'] ? \Carbon\Carbon::parse($validated['date_debut']) : now();
        $dateFinPrevue = $plan->duree_semaines ? $dateDebut->copy()->addWeeks($plan->duree_semaines) : null;

        $plan->users()->attach($user->id, [
            'date_debut' => $dateDebut,
            'date_fin_prevue' => $dateFinPrevue,
            'statut' => 'non_commence',
            'progression_pourcentage' => 0,
            'notes_utilisateur' => $validated['notes_admin'] ?? null,
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->route('admin.training.plans.assignations', $plan)
            ->with('success', 'Plan assigné à ' . $user->name . ' avec succès.');
    }

    public function unassignUser(Request $request, Plan $plan, User $user): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $plan->users()->detach($user->id);

        return redirect()->route('admin.training.plans.assignations', $plan)
            ->with('success', 'Plan retiré de ' . $user->name . ' avec succès.');
    }

    public function updateAssignation(Request $request, Plan $plan, User $user): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'statut' => 'required|in:non_commence,en_cours,pause,termine,abandonne',
            'progression_pourcentage' => 'required|integer|min:0|max:100',
            'notes_admin' => 'nullable|string|max:500',
        ]);

        $plan->users()->updateExistingPivot($user->id, [
            'statut' => $validated['statut'],
            'progression_pourcentage' => $validated['progression_pourcentage'],
            'notes_utilisateur' => $validated['notes_admin'] ?? null,
        ]);

        return redirect()->route('admin.training.plans.assignations', $plan)
            ->with('success', 'Assignation mise à jour avec succès.');
    }
}