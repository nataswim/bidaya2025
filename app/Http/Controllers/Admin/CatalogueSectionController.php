<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogueSection;
use App\Http\Requests\StoreCatalogueSectionRequest;
use App\Http\Requests\UpdateCatalogueSectionRequest;
use Illuminate\Http\Request;

/**
 * 🇬🇧 CatalogueSectionController - Admin management for catalogue sections
 * 🇫🇷 CatalogueSectionController - Gestion admin des sections du catalogue
 * 
 * @file app/Http/Controllers/Admin/CatalogueSectionController.php
 */
class CatalogueSectionController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('editor')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $query = CatalogueSection::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        $sections = $query->withCount('modules')
                          ->orderBy('order', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(15);

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => CatalogueSection::count(),
            'active' => CatalogueSection::where('is_active', true)->count(),
            'inactive' => CatalogueSection::where('is_active', false)->count(),
        ];

        return view('admin.catalogue-sections.index', compact('sections', 'search', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.catalogue-sections.create');
    }

    public function store(StoreCatalogueSectionRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // 🇬🇧 Create section / 🇫🇷 Créer la section
        $section = CatalogueSection::create($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-sections.edit', $section)
                ->with('success', 'Section créée avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.catalogue-sections.index')
            ->with('success', 'Section créée avec succès.');
    }

    public function show(CatalogueSection $catalogueSection)
    {
        $this->checkAdminAccess();
        
        $catalogueSection->load(['modules', 'creator', 'updater']);
        $catalogueSection->loadCount('modules');
        
        return view('admin.catalogue-sections.show', compact('catalogueSection'));
    }

    public function edit(CatalogueSection $catalogueSection)
    {
        $this->checkAdminAccess();
        
        return view('admin.catalogue-sections.edit', compact('catalogueSection'));
    }

    public function update(UpdateCatalogueSectionRequest $request, CatalogueSection $catalogueSection)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // 🇬🇧 Update section / 🇫🇷 Mettre à jour la section
        $catalogueSection->update($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-sections.edit', $catalogueSection)
                ->with('success', 'Section mise à jour avec succès.');
        }

        return redirect()->route('admin.catalogue-sections.index')
            ->with('success', 'Section mise à jour avec succès.');
    }

    public function destroy(CatalogueSection $catalogueSection)
    {
        $this->checkAdminAccess();
        
        if ($catalogueSection->modules()->count() > 0) {
            return redirect()->route('admin.catalogue-sections.index')
                ->with('error', 'Impossible de supprimer une section contenant des modules.');
        }
        
        $catalogueSection->delete();

        return redirect()->route('admin.catalogue-sections.index')
            ->with('success', 'Section supprimée avec succès.');
    }
}