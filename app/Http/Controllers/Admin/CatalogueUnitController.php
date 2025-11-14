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
use App\Http\Requests\AddMultipleCatalogueUnitContentsRequest;

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
        $query = CatalogueUnit::with(['module.section', 'contents.contentable']);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($moduleId) {
            $query->where('catalogue_module_id', $moduleId);
        }

        if ($sectionId) {
            $query->whereHas('module', function ($q) use ($sectionId) {
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


    // Nouvelle méthode pour gérer les contenus
    public function contents(CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();

        $catalogueUnit->load(['module.section', 'contents.contentable']);

        return view('admin.catalogue-units.contents', compact('catalogueUnit'));
    }


    public function addContent(Request $request, CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();

        $request->validate([
            'contentable_type' => 'required|string',
            'contentable_id' => 'required|integer',
            'custom_title' => 'nullable|string|max:191',
            'custom_description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_required' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Vérifier que le contenu n'est pas déjà lié
        $exists = $catalogueUnit->contents()
            ->where('contentable_type', $request->contentable_type)
            ->where('contentable_id', $request->contentable_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ce contenu est déjà lié à cette unité.');
        }

        // Déterminer l'ordre si non fourni
        if (!$request->has('order')) {
            $maxOrder = $catalogueUnit->contents()->max('order') ?? 0;
            $request->merge(['order' => $maxOrder + 1]);
        }

        $catalogueUnit->contents()->create($request->all());

        return back()->with('success', 'Contenu ajouté avec succès.');
    }


    /**
     * Ajouter plusieurs contenus en une seule fois
     */
    public function addMultipleContents(AddMultipleCatalogueUnitContentsRequest $request, CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();

        $contentableType = $request->contentable_type;
        $contentableIds = $request->contentable_ids;

        // Récupérer l'ordre maximum actuel
        $maxOrder = $catalogueUnit->contents()->max('order') ?? 0;

        $addedCount = 0;
        $skippedCount = 0;
        $errors = [];

        foreach ($contentableIds as $index => $contentableId) {
            // Vérifier que le contenu n'est pas déjà lié
            $exists = $catalogueUnit->contents()
                ->where('contentable_type', $contentableType)
                ->where('contentable_id', $contentableId)
                ->exists();

            if ($exists) {
                $skippedCount++;
                continue;
            }

            try {
                // Créer le lien
                $catalogueUnit->contents()->create([
                    'contentable_type' => $contentableType,
                    'contentable_id' => $contentableId,
                    'order' => $maxOrder + $index + 1,
                    'is_required' => true,
                    'is_active' => true,
                ]);

                $addedCount++;
            } catch (\Exception $e) {
                $errors[] = "Erreur pour le contenu ID {$contentableId} : " . $e->getMessage();
            }
        }

        // Message de succès personnalisé
        if ($addedCount > 0) {
            $message = "{$addedCount} contenu(s) ajouté(s) avec succès.";

            if ($skippedCount > 0) {
                $message .= " {$skippedCount} contenu(s) ignoré(s) (déjà présent(s)).";
            }

            if (count($errors) > 0) {
                $message .= " Erreurs : " . implode(', ', $errors);
            }

            return back()->with('success', $message);
        }

        if ($skippedCount > 0) {
            return back()->with('error', 'Tous les contenus sélectionnés sont déjà liés à cette unité.');
        }

        return back()->with('error', 'Aucun contenu n\'a pu être ajouté. ' . implode(', ', $errors));
    }







    // Nouvelle méthode pour supprimer un contenu
    public function removeContent(CatalogueUnit $catalogueUnit, CatalogueUnitContent $content)
    {
        $this->checkAdminAccess();

        if ($content->catalogue_unit_id !== $catalogueUnit->id) {
            abort(404);
        }

        $content->delete();

        return back()->with('success', 'Contenu retiré avec succès.');
    }

    // Nouvelle méthode pour réordonner les contenus
    public function reorderContents(Request $request, CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();

        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'required|integer|exists:catalogue_unit_contents,id',
        ]);

        foreach ($request->contents as $order => $contentId) {
            $catalogueUnit->contents()
                ->where('id', $contentId)
                ->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true]);
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

        // Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        // Créer l'unité
        $unit = CatalogueUnit::create($data);

        // Gérer les contenus multiples
        if ($request->has('contents')) {
            foreach ($request->contents as $contentData) {
                if (!empty($contentData['contentable_type']) && !empty($contentData['contentable_id'])) {
                    $unit->contents()->create([
                        'contentable_type' => $contentData['contentable_type'],
                        'contentable_id' => $contentData['contentable_id'],
                        'custom_title' => $contentData['custom_title'] ?? null,
                        'custom_description' => $contentData['custom_description'] ?? null,
                        'duration_minutes' => $contentData['duration_minutes'] ?? null,
                        'order' => $contentData['order'] ?? 1,
                        'is_required' => isset($contentData['is_required']) ? true : false,
                    ]);
                }
            }
        }

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

        // Charger les contenus avec leurs relations
        $catalogueUnit->load('contents.contentable');

        // Passer l'unité à la vue (elle contient déjà les contenus)
        $unit = $catalogueUnit;

        return view('admin.catalogue-units.edit', compact('catalogueUnit', 'unit', 'sections', 'modules'));
    }





    public function update(UpdateCatalogueUnitRequest $request, CatalogueUnit $catalogueUnit)
    {
        $this->checkAdminAccess();

        $data = $request->validated();

        // Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        // Mettre à jour l'unité
        $catalogueUnit->update($data);

        // Gérer les contenus multiples
        if ($request->has('contents')) {
            // Récupérer les IDs existants
            $existingIds = [];

            foreach ($request->contents as $contentData) {
                if (!empty($contentData['contentable_type']) && !empty($contentData['contentable_id'])) {
                    if (isset($contentData['id'])) {
                        // Mettre à jour le contenu existant
                        $catalogueUnit->contents()
                            ->where('id', $contentData['id'])
                            ->update([
                                'contentable_type' => $contentData['contentable_type'],
                                'contentable_id' => $contentData['contentable_id'],
                                'custom_title' => $contentData['custom_title'] ?? null,
                                'custom_description' => $contentData['custom_description'] ?? null,
                                'duration_minutes' => $contentData['duration_minutes'] ?? null,
                                'order' => $contentData['order'] ?? 1,
                                'is_required' => isset($contentData['is_required']) ? true : false,
                            ]);
                        $existingIds[] = $contentData['id'];
                    } else {
                        // Créer un nouveau contenu
                        $newContent = $catalogueUnit->contents()->create([
                            'contentable_type' => $contentData['contentable_type'],
                            'contentable_id' => $contentData['contentable_id'],
                            'custom_title' => $contentData['custom_title'] ?? null,
                            'custom_description' => $contentData['custom_description'] ?? null,
                            'duration_minutes' => $contentData['duration_minutes'] ?? null,
                            'order' => $contentData['order'] ?? 1,
                            'is_required' => isset($contentData['is_required']) ? true : false,
                        ]);
                        $existingIds[] = $newContent->id;
                    }
                }
            }

            // Supprimer les contenus non présents dans la soumission
            $catalogueUnit->contents()
                ->whereNotIn('id', $existingIds)
                ->delete();
        } else {
            // Si aucun contenu n'est envoyé, supprimer tous les contenus existants
            $catalogueUnit->contents()->delete();
        }

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
