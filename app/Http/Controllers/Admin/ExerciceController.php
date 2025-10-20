<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use App\Models\ExerciceCategory;
use App\Models\ExerciceSousCategory;
use App\Http\Requests\StoreExerciceRequest;
use App\Http\Requests\UpdateExerciceRequest;
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
        
        $query = Exercice::with(['creator', 'category', 'sousCategory'])->withCount(['series']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $exercices = $query->ordered()->paginate(15);

        return view('admin.training.exercices.index', compact('exercices', 'search'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        
        // Charger les catégories pour le formulaire
        $categories = ExerciceCategory::active()->ordered()->get();
        $sousCategories = ExerciceSousCategory::active()->ordered()->get();
        
        return view('admin.training.exercices.create', compact('categories', 'sousCategories'));
    }

    public function store(StoreExerciceRequest $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validated();

        Exercice::create($validated);

        return redirect()->route('admin.training.exercices.index')
            ->with('success', 'Exercice créé avec succès.');
    }

    public function show(Exercice $exercice): View
    {
        $this->checkAdminAccess();
        $exercice->load(['creator', 'series', 'category', 'sousCategory']);
        return view('admin.training.exercices.show', compact('exercice'));
    }

    public function edit(Exercice $exercice): View
    {
        $this->checkAdminAccess();
        
        // Charger les catégories pour le formulaire
        $categories = ExerciceCategory::active()->ordered()->get();
        $sousCategories = ExerciceSousCategory::active()->ordered()->get();
        
        return view('admin.training.exercices.edit', compact('exercice', 'categories', 'sousCategories'));
    }

    public function update(UpdateExerciceRequest $request, Exercice $exercice): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validated();

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