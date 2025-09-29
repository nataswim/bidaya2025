<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SerieController extends Controller
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
        $exercice_id = $request->input('exercice_id');
        
        $query = Serie::with(['exercice', 'creator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('consignes', 'like', "%{$search}%")
                  ->orWhereHas('exercice', function($eq) use ($search) {
                      $eq->where('titre', 'like', "%{$search}%");
                  });
            });
        }

        if ($exercice_id) {
            $query->where('exercice_id', $exercice_id);
        }

        $series = $query->ordered()->paginate(15);
        $exercices = Exercice::active()->ordered()->get();

        return view('admin.training.series.index', compact('series', 'exercices', 'search', 'exercice_id'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        $exercices = Exercice::active()->ordered()->get();
        return view('admin.training.series.create', compact('exercices'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'exercice_id' => 'required|exists:exercices,id',
            'nom' => 'nullable|string|max:255',
            'repetitions' => 'nullable|integer|min:1|max:1000',
            'duree_secondes' => 'nullable|integer|min:1|max:86400',
            'distance_metres' => 'nullable|numeric|min:0|max:100000',
            'poids_kg' => 'nullable|numeric|min:0|max:1000',
            'repos_secondes' => 'required|integer|min:0|max:3600',
            'consignes' => 'nullable|string',
            'ordre' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Serie::create($validated);

        return redirect()->route('admin.training.series.index')
            ->with('success', 'Série créée avec succès.');
    }

    public function show(Serie $series): View
    {
        $this->checkAdminAccess();
        $series->load(['exercice', 'creator', 'seances']);
        return view('admin.training.series.show', compact('series'));
    }

    public function edit(Serie $series): View
    {
        $this->checkAdminAccess();
        $exercices = Exercice::active()->ordered()->get();
        return view('admin.training.series.edit', compact('series', 'exercices'));
    }

    public function update(Request $request, Serie $series): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'exercice_id' => 'required|exists:exercices,id',
            'nom' => 'nullable|string|max:255',
            'repetitions' => 'nullable|integer|min:1|max:1000',
            'duree_secondes' => 'nullable|integer|min:1|max:86400',
            'distance_metres' => 'nullable|numeric|min:0|max:100000',
            'poids_kg' => 'nullable|numeric|min:0|max:1000',
            'repos_secondes' => 'required|integer|min:0|max:3600',
            'consignes' => 'nullable|string',
            'ordre' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? $series->ordre;

        $series->update($validated);

        return redirect()->route('admin.training.series.index')
            ->with('success', 'Série mise à jour avec succès.');
    }

    public function destroy(Serie $series): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si la série est utilisée dans des séances
        if ($series->seances()->count() > 0) {
            return redirect()->route('admin.training.series.index')
                ->with('error', 'Impossible de supprimer une série utilisée dans des séances.');
        }

        $series->delete();

        return redirect()->route('admin.training.series.index')
            ->with('success', 'Série supprimée avec succès.');
    }
}