<?php

namespace App\Http\Controllers;

use App\Models\FichesCategory;
use Illuminate\Http\Request;

/**
 * 🇬🇧 FichesCategoryController - Admin management for fiches categories
 * 🇫🇷 FichesCategoryController - Gestion admin des catégories de fiches
 * 
 * @file app/Http/Controllers/FichesCategoryController.php
 */
class FichesCategoryController extends Controller
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
        $query = FichesCategory::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->withCount('fiches')
                           ->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(10);

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => FichesCategory::count(),
            'active' => FichesCategory::where('is_active', true)->count(),
            'inactive' => FichesCategory::where('is_active', false)->count(),
        ];

        return view('admin.fiches-categories.index', compact('categories', 'search', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.fiches-categories.create');
    }

    public function store(Request $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:fiches_categories,slug',
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

        $data['created_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active', true);
        
        FichesCategory::create($data);

        return redirect()->route('admin.fiches-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(FichesCategory $fichesCategory)
    {
        $this->checkAdminAccess();
        
        $fichesCategory->loadCount('fiches');
        
        return view('admin.fiches-categories.show', compact('fichesCategory'));
    }

    public function edit(FichesCategory $fichesCategory)
    {
        $this->checkAdminAccess();
        
        return view('admin.fiches-categories.edit', compact('fichesCategory'));
    }

    public function update(Request $request, FichesCategory $fichesCategory)
    {
        $this->checkAdminAccess();
        
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:fiches_categories,slug,' . $fichesCategory->id,
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

        $data['updated_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active', true);
        
        $fichesCategory->update($data);

        return redirect()->route('admin.fiches-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(FichesCategory $fichesCategory)
    {
        $this->checkAdminAccess();
        
        if ($fichesCategory->fiches()->count() > 0) {
            return redirect()->route('admin.fiches-categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des fiches.');
        }
        
        $fichesCategory->update(['deleted_by' => auth()->id()]);
        $fichesCategory->delete();

        return redirect()->route('admin.fiches-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}