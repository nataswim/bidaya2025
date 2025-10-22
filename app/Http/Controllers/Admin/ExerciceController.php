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
    
    // Query de base avec eager loading
    $query = Exercice::with(['creator', 'categories', 'sousCategories'])
        ->withCount(['series']);

    // Appliquer la recherche
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Tri et pagination
    $exercices = $query->orderBy('ordre')
                       ->orderBy('titre')
                       ->paginate(15);

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
    
    // Extraire les catégories avant la création
    $categories = $request->input('categories', []);
    $sousCategories = $request->input('sous_categories', []);
    
    // Supprimer les champs de catégories de $validated
    unset($validated['categories'], $validated['sous_categories']);

    // Créer l'exercice
    $exercice = Exercice::create($validated);
    
    // Attacher les catégories
    if (!empty($categories)) {
        $exercice->categories()->attach($categories);
    }
    
    // Attacher les sous-catégories
    if (!empty($sousCategories)) {
        $exercice->sousCategories()->attach($sousCategories);
    }

    return redirect()->route('admin.training.exercices.index')
        ->with('success', 'Exercice créé avec succès.');
}





    public function show(Exercice $exercice): View
{
    $this->checkAdminAccess();
    
    // Charger toutes les relations (pluriel pour many-to-many)
    $exercice->load(['creator', 'series', 'categories', 'sousCategories']);
    
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
    
    // Extraire les catégories
    $categories = $request->input('categories', []);
    $sousCategories = $request->input('sous_categories', []);
    
    // Supprimer les champs de catégories de $validated
    unset($validated['categories'], $validated['sous_categories']);

    // Mettre à jour l'exercice
    $exercice->update($validated);
    
    // Synchroniser les catégories (remplace toutes les relations)
    $exercice->categories()->sync($categories);
    
    // Synchroniser les sous-catégories
    $exercice->sousCategories()->sync($sousCategories);

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

/**
 * Assignation en masse de catégories aux exercices
 */
public function bulkAssignCategories(Request $request): RedirectResponse
{
    $this->checkAdminAccess();
    
    $validated = $request->validate([
        'exercices' => 'required|array|min:1',
        'exercices.*' => 'exists:exercices,id',
        'action' => 'required|in:add,replace,remove',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:exercice_categories,id',
        'sous_categories' => 'nullable|array',
        'sous_categories.*' => 'exists:exercice_sous_categories,id',
    ]);
    
    $exerciceIds = $validated['exercices'];
    $action = $validated['action'];
    $categories = $validated['categories'] ?? [];
    $sousCategories = $validated['sous_categories'] ?? [];
    
    $count = 0;
    
    foreach ($exerciceIds as $exerciceId) {
        $exercice = Exercice::find($exerciceId);
        
        if (!$exercice) {
            continue;
        }
        
        switch ($action) {
            case 'add':
                // Ajouter sans supprimer les existantes
                if (!empty($categories)) {
                    $exercice->categories()->syncWithoutDetaching($categories);
                }
                if (!empty($sousCategories)) {
                    $exercice->sousCategories()->syncWithoutDetaching($sousCategories);
                }
                break;
                
            case 'replace':
                // Remplacer toutes les catégories
                $exercice->categories()->sync($categories);
                $exercice->sousCategories()->sync($sousCategories);
                break;
                
            case 'remove':
                // Supprimer uniquement les catégories sélectionnées
                if (!empty($categories)) {
                    $exercice->categories()->detach($categories);
                }
                if (!empty($sousCategories)) {
                    $exercice->sousCategories()->detach($sousCategories);
                }
                break;
        }
        
        $count++;
    }
    
    $actionLabel = match($action) {
        'add' => 'ajoutées à',
        'replace' => 'remplacées pour',
        'remove' => 'supprimées de',
    };
    
    return redirect()->route('admin.training.exercices.index')
        ->with('success', "Catégories {$actionLabel} {$count} exercice(s) avec succès.");
}

}