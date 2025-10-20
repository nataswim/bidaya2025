<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExerciceSousCategory;
use App\Models\ExerciceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExerciceSousCategoryController extends Controller
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
        $categoryId = $request->input('category');
        
        $query = ExerciceSousCategory::with('category');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('exercice_category_id', $categoryId);
        }

        $sousCategories = $query->withCount('exercices')
                               ->orderBy('sort_order', 'asc')
                               ->orderBy('name', 'asc')
                               ->paginate(15);

        $categories = ExerciceCategory::active()->ordered()->get();

        // Statistiques
        $stats = [
            'total' => ExerciceSousCategory::count(),
            'active' => ExerciceSousCategory::where('is_active', true)->count(),
            'inactive' => ExerciceSousCategory::where('is_active', false)->count(),
        ];

        return view('admin.exercice-sous-categories.index', compact('sousCategories', 'categories', 'search', 'categoryId', 'stats'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        
        $categories = ExerciceCategory::active()->ordered()->get();
        
        return view('admin.exercice-sous-categories.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:exercice_sous_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'exercice_category_id' => 'required|exists:exercice_categories,id',
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
        
        ExerciceSousCategory::create($data);

        return redirect()->route('admin.exercice-sous-categories.index')
            ->with('success', 'Sous-catégorie créée avec succès.');
    }

    public function show(ExerciceSousCategory $exerciceSousCategory): View
    {
        $this->checkAdminAccess();
        
        $exerciceSousCategory->load(['category', 'exercices']);
        $exerciceSousCategory->loadCount('exercices');
        
        return view('admin.exercice-sous-categories.show', compact('exerciceSousCategory'));
    }

    public function edit(ExerciceSousCategory $exerciceSousCategory): View
    {
        $this->checkAdminAccess();
        
        $categories = ExerciceCategory::active()->ordered()->get();
        
        return view('admin.exercice-sous-categories.edit', compact('exerciceSousCategory', 'categories'));
    }

    public function update(Request $request, ExerciceSousCategory $exerciceSousCategory): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:exercice_sous_categories,slug,' . $exerciceSousCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'exercice_category_id' => 'required|exists:exercice_categories,id',
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
        
        $exerciceSousCategory->update($data);

        return redirect()->route('admin.exercice-sous-categories.index')
            ->with('success', 'Sous-catégorie mise à jour avec succès.');
    }

    public function destroy(ExerciceSousCategory $exerciceSousCategory): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si des exercices utilisent cette sous-catégorie
        if ($exerciceSousCategory->exercices()->count() > 0) {
            return redirect()->route('admin.exercice-sous-categories.index')
                ->with('error', 'Impossible de supprimer une sous-catégorie contenant des exercices.');
        }
        
        $exerciceSousCategory->delete();

        return redirect()->route('admin.exercice-sous-categories.index')
            ->with('success', 'Sous-catégorie supprimée avec succès.');
    }

    /**
     * API endpoint pour récupérer les sous-catégories par catégorie
     */
    public function apiByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json([]);
        }

        $sousCategories = ExerciceSousCategory::where('exercice_category_id', $categoryId)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'slug']);

        return response()->json($sousCategories);
    }
}