<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExerciceController extends Controller
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
        $niveau = $request->input('niveau');
        $type = $request->input('type');
        
        $query = Exercice::with(['creator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($niveau) {
            $query->where('niveau', $niveau);
        }

        if ($type) {
            $query->where('type_exercice', $type);
        }

        $exercices = $query->ordered()->paginate(15);

        return view('admin.training.exercices.index', compact('exercices', 'search', 'niveau', 'type'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        return view('admin.training.exercices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'muscles_cibles' => 'nullable|array',
            'muscles_cibles.*' => 'string|max:50',
            'consignes_securite' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'type_exercice' => 'required|in:cardio,force,flexibilite,equilibre',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Exercice::create($validated);

        return redirect()->route('admin.training.exercices.index')
            ->with('success', 'Exercice créé avec succès.');
    }

    public function show(Exercice $exercice): View
    {
        $this->checkAdminAccess();
        $exercice->load(['creator', 'series']);
        return view('admin.training.exercices.show', compact('exercice'));
    }

    public function edit(Exercice $exercice): View
    {
        $this->checkAdminAccess();
        return view('admin.training.exercices.edit', compact('exercice'));
    }

    public function update(Request $request, Exercice $exercice): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'muscles_cibles' => 'nullable|array',
            'muscles_cibles.*' => 'string|max:50',
            'consignes_securite' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'type_exercice' => 'required|in:cardio,force,flexibilite,equilibre',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? $exercice->ordre;

        $exercice->update($validated);

        return redirect()->route('admin.training.exercices.index')
            ->with('success', 'Exercice mis à jour avec succès.');
    }

    public function destroy(Exercice $exercice): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si l'exercice est utilisé dans des séries
        if ($exercice->series()->count() > 0) {
            return redirect()->route('admin.training.exercices.index')
                ->with('error', 'Impossible de supprimer un exercice utilisé dans des séries.');
        }

        $exercice->delete();

        return redirect()->route('admin.training.exercices.index')
            ->with('success', 'Exercice supprimé avec succès.');
    }
}