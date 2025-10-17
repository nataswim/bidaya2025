<?php

namespace App\Http\Controllers;

use App\Models\FichesSousCategory;
use App\Models\FichesCategory;
use Illuminate\Http\Request;

/**
 * 🇬🇧 FichesSousCategoryController - Admin management for fiches sub-categories
 * 🇫🇷 FichesSousCategoryController - Gestion admin des sous-catégories de fiches
 * 
 * @file app/Http/Controllers/FichesSousCategoryController.php
 */
class FichesSousCategoryController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $categoryId = $request->input('category');
        
        $query = FichesSousCategory::with('category');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('fiches_category_id', $categoryId);
        }

        $sousCategories = $query->withCount('fiches')
                               ->orderBy('sort_order', 'asc')
                               ->orderBy('name', 'asc')
                               ->paginate(15);

        $categories = FichesCategory::active()->ordered()->get();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => FichesSousCategory::count(),
            'active' => FichesSousCategory::where('is_active', true)->count(),
            'inactive' => FichesSousCategory::where('is_active', false)->count(),
        ];

        return view('admin.fiches-sous-categories.index', compact('sousCategories', 'categories', 'search', 'categoryId', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = FichesCategory::active()->ordered()->get();
        
        return view('admin.fiches-sous-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:fiches_sous_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'fiches_category_id' => 'required|exists:fiches_categories,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $data['created_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active', true);
        
        FichesSousCategory::create($data);

        return redirect()->route('admin.fiches-sous-categories.index')
            ->with('success', 'Sous-catégorie créée avec succès.');
    }

    public function show(FichesSousCategory $fichesSousCategory)
    {
        $this->checkAdminAccess();
        
        $fichesSousCategory->load(['category', 'fiches']);
        $fichesSousCategory->loadCount('fiches');
        
        return view('admin.fiches-sous-categories.show', compact('fichesSousCategory'));
    }

    public function edit(FichesSousCategory $fichesSousCategory)
    {
        $this->checkAdminAccess();
        
        $categories = FichesCategory::active()->ordered()->get();
        
        return view('admin.fiches-sous-categories.edit', compact('fichesSousCategory', 'categories'));
    }

    public function update(Request $request, FichesSousCategory $fichesSousCategory)
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:fiches_sous_categories,slug,' . $fichesSousCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'fiches_category_id' => 'required|exists:fiches_categories,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }

        $data['updated_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active', true);
        
        $fichesSousCategory->update($data);

        return redirect()->route('admin.fiches-sous-categories.index')
            ->with('success', 'Sous-catégorie mise à jour avec succès.');
    }

    public function destroy(FichesSousCategory $fichesSousCategory)
    {
        $this->checkAdminAccess();
        
        if ($fichesSousCategory->fiches()->count() > 0) {
            return redirect()->route('admin.fiches-sous-categories.index')
                ->with('error', 'Impossible de supprimer une sous-catégorie contenant des fiches.');
        }
        
        $fichesSousCategory->update(['deleted_by' => auth()->id()]);
        $fichesSousCategory->delete();

        return redirect()->route('admin.fiches-sous-categories.index')
            ->with('success', 'Sous-catégorie supprimée avec succès.');
    }

    /**
     * 🇬🇧 API endpoint to get sub-categories by category
     * 🇫🇷 Point d'API pour récupérer les sous-catégories par catégorie
     */
    public function apiByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        if (!$categoryId) {
            return response()->json([]);
        }

        $sousCategories = FichesSousCategory::where('fiches_category_id', $categoryId)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'slug']);

        return response()->json($sousCategories);
    }
}