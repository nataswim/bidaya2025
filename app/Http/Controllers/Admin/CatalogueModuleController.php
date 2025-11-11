<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogueModule;
use App\Models\CatalogueSection;
use App\Http\Requests\StoreCatalogueModuleRequest;
use App\Http\Requests\UpdateCatalogueModuleRequest;
use Illuminate\Http\Request;

/**
 * 🇬🇧 CatalogueModuleController - Admin management for catalogue modules
 * 🇫🇷 CatalogueModuleController - Gestion admin des modules du catalogue
 * 
 * @file app/Http/Controllers/Admin/CatalogueModuleController.php
 */
class CatalogueModuleController extends Controller
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
        $sectionId = $request->input('section');
        
        $query = CatalogueModule::with('section');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        if ($sectionId) {
            $query->where('catalogue_section_id', $sectionId);
        }

        $modules = $query->withCount('units')
                         ->orderBy('order', 'asc')
                         ->orderBy('name', 'asc')
                         ->paginate(15);

        $sections = CatalogueSection::active()->ordered()->get();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => CatalogueModule::count(),
            'active' => CatalogueModule::where('is_active', true)->count(),
            'inactive' => CatalogueModule::where('is_active', false)->count(),
        ];

        return view('admin.catalogue-modules.index', compact('modules', 'sections', 'search', 'sectionId', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $sections = CatalogueSection::active()->ordered()->get();
        
        return view('admin.catalogue-modules.create', compact('sections'));
    }

    public function store(StoreCatalogueModuleRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // 🇬🇧 Create module / 🇫🇷 Créer le module
        $module = CatalogueModule::create($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-modules.edit', $module)
                ->with('success', 'Module créé avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.catalogue-modules.index')
            ->with('success', 'Module créé avec succès.');
    }

    public function show(CatalogueModule $catalogueModule)
    {
        $this->checkAdminAccess();
        
        $catalogueModule->load(['section', 'units', 'creator', 'updater']);
        $catalogueModule->loadCount('units');
        
        return view('admin.catalogue-modules.show', compact('catalogueModule'));
    }

    public function edit(CatalogueModule $catalogueModule)
    {
        $this->checkAdminAccess();
        
        $sections = CatalogueSection::active()->ordered()->get();
        
        return view('admin.catalogue-modules.edit', compact('catalogueModule', 'sections'));
    }

    public function update(UpdateCatalogueModuleRequest $request, CatalogueModule $catalogueModule)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        // 🇬🇧 Update module / 🇫🇷 Mettre à jour le module
        $catalogueModule->update($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-modules.edit', $catalogueModule)
                ->with('success', 'Module mis à jour avec succès.');
        }

        return redirect()->route('admin.catalogue-modules.index')
            ->with('success', 'Module mis à jour avec succès.');
    }

    public function destroy(CatalogueModule $catalogueModule)
    {
        $this->checkAdminAccess();
        
        if ($catalogueModule->units()->count() > 0) {
            return redirect()->route('admin.catalogue-modules.index')
                ->with('error', 'Impossible de supprimer un module contenant des unités.');
        }
        
        $catalogueModule->delete();

        return redirect()->route('admin.catalogue-modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }
}