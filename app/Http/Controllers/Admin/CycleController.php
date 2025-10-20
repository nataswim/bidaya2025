<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CycleController extends Controller
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
        
        $query = Cycle::with(['creator'])->withCount(['seances']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $cycles = $query->ordered()->paginate(15);

        return view('admin.training.cycles.index', compact('cycles', 'search'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        $seances = Seance::active()->ordered()->get();
        return view('admin.training.cycles.create', compact('seances'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duree_semaines' => 'nullable|integer|min:1|max:104',
            'objectif' => 'nullable|string|max:50',
            'conseils' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'seances' => 'nullable|array',
            'seances.*.seance_id' => 'required_with:seances|exists:seances,id',
            'seances.*.ordre' => 'required_with:seances|integer|min:1',
            'seances.*.jour_semaine' => 'nullable|integer|min:1|max:7',
            'seances.*.semaine_cycle' => 'required_with:seances|integer|min:1',
            'seances.*.notes' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $cycle = Cycle::create($validated);

        // Attacher les séances
        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $seance) {
                $cycle->seances()->attach($seance['seance_id'], [
                    'ordre' => $seance['ordre'],
                    'jour_semaine' => $seance['jour_semaine'] ?? null,
                    'semaine_cycle' => $seance['semaine_cycle'],
                    'notes' => $seance['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.training.cycles.index')
            ->with('success', 'Cycle créé avec succès.');
    }

    public function show(Cycle $cycle): View
    {
        $this->checkAdminAccess();
        $cycle->load(['creator', 'seances.series.exercice', 'plans']);
        return view('admin.training.cycles.show', compact('cycle'));
    }

    public function edit(Cycle $cycle): View
    {
        $this->checkAdminAccess();
        $cycle->load(['seances']);
        $seances = Seance::active()->ordered()->get();
        return view('admin.training.cycles.edit', compact('cycle', 'seances'));
    }

    public function update(Request $request, Cycle $cycle): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duree_semaines' => 'nullable|integer|min:1|max:104',
            'objectif' => 'nullable|string|max:50',
            'conseils' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'seances' => 'nullable|array',
            'seances.*.seance_id' => 'required_with:seances|exists:seances,id',
            'seances.*.ordre' => 'required_with:seances|integer|min:1',
            'seances.*.jour_semaine' => 'nullable|integer|min:1|max:7',
            'seances.*.semaine_cycle' => 'required_with:seances|integer|min:1',
            'seances.*.notes' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? $cycle->ordre;

        $cycle->update($validated);

        // Resynchroniser les séances
        $cycle->seances()->detach();
        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $seance) {
                $cycle->seances()->attach($seance['seance_id'], [
                    'ordre' => $seance['ordre'],
                    'jour_semaine' => $seance['jour_semaine'] ?? null,
                    'semaine_cycle' => $seance['semaine_cycle'],
                    'notes' => $seance['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.training.cycles.index')
            ->with('success', 'Cycle mis à jour avec succès.');
    }

    public function destroy(Cycle $cycle): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si le cycle est utilisé dans des plans
        if ($cycle->plans()->count() > 0) {
            return redirect()->route('admin.training.cycles.index')
                ->with('error', 'Impossible de supprimer un cycle utilisé dans des plans.');
        }

        $cycle->seances()->detach();
        $cycle->delete();

        return redirect()->route('admin.training.cycles.index')
            ->with('success', 'Cycle supprimé avec succès.');
    }
}