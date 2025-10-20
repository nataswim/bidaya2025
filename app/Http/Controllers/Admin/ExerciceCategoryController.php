<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExerciceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExerciceCategoryController extends Controller
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
        $query = ExerciceCategory::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->withCount(['exercices', 'sousCategories'])
                           ->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(15);

        // Statistiques
        $stats = [
            'total' => ExerciceCategory::count(),
            'active' => ExerciceCategory::where('is_active', true)->count(),
            'inactive' => ExerciceCategory::where('is_active', false)->count(),
        ];

        return view('admin.exercice-categories.index', compact('categories', 'search', 'stats'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        
        return view('admin.exercice-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:exercice_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        
        ExerciceCategory::create($data);

        return redirect()->route('admin.exercice-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(ExerciceCategory $exerciceCategory): View
    {
        $this->checkAdminAccess();
        
        $exerciceCategory->loadCount(['exercices', 'sousCategories']);
        $exerciceCategory->load(['sousCategories' => function($query) {
            $query->withCount('exercices')->ordered();
        }]);
        
        return view('admin.exercice-categories.show', compact('exerciceCategory'));
    }

    public function edit(ExerciceCategory $exerciceCategory): View
    {
        $this->checkAdminAccess();
        
        return view('admin.exercice-categories.edit', compact('exerciceCategory'));
    }

    public function update(Request $request, ExerciceCategory $exerciceCategory): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:exercice_categories,slug,' . $exerciceCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        
        $exerciceCategory->update($data);

        return redirect()->route('admin.exercice-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(ExerciceCategory $exerciceCategory): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si des exercices utilisent cette catégorie
        if ($exerciceCategory->exercices()->count() > 0) {
            return redirect()->route('admin.exercice-categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des exercices.');
        }
        
        // Vérifier si des sous-catégories existent
        if ($exerciceCategory->sousCategories()->count() > 0) {
            return redirect()->route('admin.exercice-categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des sous-catégories.');
        }
        
        $exerciceCategory->delete();

        return redirect()->route('admin.exercice-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}