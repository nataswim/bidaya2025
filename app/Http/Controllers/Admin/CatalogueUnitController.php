<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogueUnit;
use App\Models\CatalogueModule;
use App\Models\CatalogueSection;
use App\Models\Post;
use App\Models\Video;
use App\Models\Downloadable;
use App\Models\Fiche;
use App\Models\Exercice;
use App\Models\Workout;
use App\Models\EbookFile;
use App\Http\Requests\StoreCatalogueUnitRequest;
use App\Http\Requests\UpdateCatalogueUnitRequest;
use Illuminate\Http\Request;

/**
 * 🇬🇧 CatalogueUnitController - Admin management for catalogue units
 * 🇫🇷 CatalogueUnitController - Gestion admin des unités du catalogue
 * 
 * @file app/Http/Controllers/Admin/CatalogueUnitController.php
 */
class CatalogueUnitController extends Controller
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
        $moduleId = $request->input('module');
        $sectionId = $request->input('section');
        $contentType = $request->input('content_type');
        
        $query = CatalogueUnit::with(['module.section', 'unitable']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($moduleId) {
            $query->where('catalogue_module_id', $moduleId);
        }

        if ($sectionId) {
            $query->whereHas('module', function($q) use ($sectionId) {
                $q->where('catalogue_section_id', $sectionId);
            });
        }

        if ($contentType) {
            $query->where('unitable_type', $contentType);
        }

        $units = $query->orderBy('order', 'asc')
                       ->orderBy('title', 'asc')
                       ->paginate(15);

        $sections = CatalogueSection::active()->ordered()->get();
        $modules = CatalogueModule::active()->ordered()->get();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => CatalogueUnit::count(),
            'active' => CatalogueUnit::where('is_active', true)->count(),
            'inactive' => CatalogueUnit::where('is_active', false)->count(),
            'with_content' => CatalogueUnit::whereNotNull('unitable_type')->count(),
        ];

        return view('admin.catalogue-units.index', compact('units', 'sections', 'modules', 'search', 'moduleId', 'sectionId', 'contentType', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $sections = CatalogueSection::active()->ordered()->get();
        $modules = CatalogueModule::active()->ordered()->get();
        
        return view('admin.catalogue-units.create', compact('sections', 'modules'));
    }

    public function store(StoreCatalogueUnitRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Create unit / 🇫🇷 Créer l'unité
        $unit = CatalogueUnit::create($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-units.edit', $unit)
                ->with('success', 'Unité créée avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.catalogue-units.index')
            ->with('success', 'Unité créée avec succès.');
    }

    public function show(CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();
        
        $catalogueUnit->load(['module.section', 'unitable', 'creator', 'updater']);
        
        return view('admin.catalogue-units.show', compact('catalogueUnit'));
    }

    public function edit(CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();
        
        $sections = CatalogueSection::active()->ordered()->get();
        $modules = CatalogueModule::active()->ordered()->get();
        
        return view('admin.catalogue-units.edit', compact('catalogueUnit', 'sections', 'modules'));
    }

    public function update(UpdateCatalogueUnitRequest $request, CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Update unit / 🇫🇷 Mettre à jour l'unité
        $catalogueUnit->update($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.catalogue-units.edit', $catalogueUnit)
                ->with('success', 'Unité mise à jour avec succès.');
        }

        return redirect()->route('admin.catalogue-units.index')
            ->with('success', 'Unité mise à jour avec succès.');
    }

    public function destroy(CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();
        
        $catalogueUnit->delete();

        return redirect()->route('admin.catalogue-units.index')
            ->with('success', 'Unité supprimée avec succès.');
    }

    /**
     * 🇬🇧 API endpoint to get modules by section
     * 🇫🇷 Point d'API pour récupérer les modules par section
     */
    public function apiModulesBySection(Request $request)
    {
        $this->checkAdminAccess();
        
        $sectionId = $request->input('section_id');
        
        if (!$sectionId) {
            return response()->json([]);
        }

        $modules = CatalogueModule::where('catalogue_section_id', $sectionId)
            ->active()
            ->ordered()
            ->get(['id', 'name', 'slug']);

        return response()->json($modules);
    }

    /**
     * 🇬🇧 API endpoint to get available content by type
     * 🇫🇷 Point d'API pour récupérer le contenu disponible par type
     */
    public function apiContentByType(Request $request)
    {
        $this->checkAdminAccess();
        
        $contentType = $request->input('content_type');
        
        if (!$contentType) {
            return response()->json([]);
        }

        $content = [];

        switch ($contentType) {
            case 'App\Models\Post':
                $content = Post::published()->get(['id', 'name as title', 'slug']);
                break;
            case 'App\Models\Video':
                $content = Video::where('is_published', true)->get(['id', 'title', 'slug']);
                break;
            case 'App\Models\Downloadable':
                $content = Downloadable::where('is_active', true)->get(['id', 'title', 'slug']);
                break;
            case 'App\Models\Fiche':
                $content = Fiche::published()->get(['id', 'title', 'slug']);
                break;
            case 'App\Models\Exercice':
                $content = Exercice::where('is_active', true)->get(['id', 'name as title', 'slug']);
                break;
            case 'App\Models\Workout':
                $content = Workout::where('is_active', true)->get(['id', 'name as title', 'slug']);
                break;
            case 'App\Models\EbookFile':
                $content = EbookFile::get(['id', 'title', 'slug']);
                break;
        }

        return response()->json($content);
    }
}