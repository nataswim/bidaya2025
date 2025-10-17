<?php

namespace App\Http\Controllers;

use App\Models\Fiche;
use App\Models\FichesCategory;
use App\Models\FichesSousCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFicheRequest;
use App\Http\Requests\UpdateFicheRequest;

/**
 * 🇬🇧 FicheController - Admin management for fiches
 * 🇫🇷 FicheController - Gestion admin des fiches
 * 
 * @file app/Http/Controllers/FicheController.php
 */
class FicheController extends Controller
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
        $visibility = $request->input('visibility');
        $categoryId = $request->input('category');
        $sousCategoryId = $request->input('sous_category');
        $featured = $request->input('featured');
        
        $query = Fiche::with(['category', 'sousCategory', 'creator']);

        // 🇬🇧 Search filter / 🇫🇷 Filtrage par recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        // 🇬🇧 Visibility filter / 🇫🇷 Filtrage par visibilité
        if ($visibility) {
            $query->where('visibility', $visibility);
        }

        // 🇬🇧 Category filter / 🇫🇷 Filtrage par catégorie
        if ($categoryId) {
            $query->where('fiches_category_id', $categoryId);
        }

        // 🇬🇧 Sub-category filter / 🇫🇷 Filtrage par sous-catégorie
        if ($sousCategoryId) {
            $query->where('fiches_sous_category_id', $sousCategoryId);
        }

        // 🇬🇧 Featured filter / 🇫🇷 Filtrage par mise en avant
        if ($featured) {
            $query->where('is_featured', true);
        }

        $fiches = $query->orderBy('sort_order', 'asc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        $categories = FichesCategory::active()->ordered()->get();

        // 🇬🇧 Load sub-categories if category selected / 🇫🇷 Charger les sous-catégories si catégorie sélectionnée
        $sousCategories = $categoryId 
            ? FichesSousCategory::where('fiches_category_id', $categoryId)->active()->ordered()->get()
            : collect();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => Fiche::count(),
            'published' => Fiche::where('is_published', true)->count(),
            'draft' => Fiche::where('is_published', false)->count(),
            'public' => Fiche::where('visibility', 'public')->count(),
            'authenticated' => Fiche::where('visibility', 'authenticated')->count(),
            'featured' => Fiche::where('is_featured', true)->count(),
        ];

        return view('admin.fiches.index', compact(
            'fiches',
            'categories',
            'sousCategories',
            'stats',
            'search',
            'visibility',
            'categoryId',
            'sousCategoryId',
            'featured'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = FichesCategory::active()->ordered()->get();
        
        return view('admin.fiches.create', compact('categories'));
    }

    public function store(StoreFicheRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Set published_at if published / 🇫🇷 Définir published_at si publié
        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        // 🇬🇧 Creation info / 🇫🇷 Informations de création
        $data['created_by'] = auth()->id();
        $data['created_by_name'] = auth()->user()->name;
        
        // 🇬🇧 Auto-set parent category if sous-category selected / 🇫🇷 Définir automatiquement la catégorie parente
        if (!empty($data['fiches_sous_category_id']) && empty($data['fiches_category_id'])) {
            $sousCategory = FichesSousCategory::find($data['fiches_sous_category_id']);
            if ($sousCategory) {
                $data['fiches_category_id'] = $sousCategory->fiches_category_id;
            }
        }
        
        // 🇬🇧 Create fiche / 🇫🇷 Créer la fiche
        $fiche = Fiche::create($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.fiches.edit', $fiche)
                ->with('success', 'Fiche créée avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.fiches.index')
            ->with('success', 'Fiche créée avec succès.');
    }

    public function show(Fiche $fiche)
    {
        $this->checkAdminAccess();
        
        $fiche->load(['category', 'sousCategory', 'creator', 'updater']);
        
        return view('admin.fiches.show', compact('fiche'));
    }

    public function edit(Fiche $fiche)
    {
        $this->checkAdminAccess();
        
        $categories = FichesCategory::active()->ordered()->get();
        
        // 🇬🇧 Load sub-categories of selected category / 🇫🇷 Charger les sous-catégories de la catégorie sélectionnée
        $sousCategories = $fiche->fiches_category_id 
            ? FichesSousCategory::where('fiches_category_id', $fiche->fiches_category_id)->active()->ordered()->get()
            : collect();
        
        $fiche->load(['category', 'sousCategory']);
        
        return view('admin.fiches.edit', compact('fiche', 'categories', 'sousCategories'));
    }

    public function update(UpdateFicheRequest $request, Fiche $fiche)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Handle published_at / 🇫🇷 Gérer la date de publication
        if (!empty($data['is_published'])) {
            if (empty($data['published_at']) && !$fiche->is_published) {
                $data['published_at'] = now();
            }
        }
        
        // 🇬🇧 Update info / 🇫🇷 Informations de modification
        $data['updated_by'] = auth()->id();
        
        // 🇬🇧 Auto-update parent category if sous-category changed / 🇫🇷 Mettre à jour automatiquement la catégorie parente
        if (!empty($data['fiches_sous_category_id'])) {
            $sousCategory = FichesSousCategory::find($data['fiches_sous_category_id']);
            if ($sousCategory) {
                $data['fiches_category_id'] = $sousCategory->fiches_category_id;
            }
        }
        
        // 🇬🇧 Update fiche / 🇫🇷 Mettre à jour la fiche
        $fiche->update($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.fiches.edit', $fiche)
                ->with('success', 'Fiche mise à jour avec succès.');
        }

        return redirect()->route('admin.fiches.index')
            ->with('success', 'Fiche mise à jour avec succès.');
    }

    public function destroy(Fiche $fiche)
    {
        $this->checkAdminAccess();
        
        // 🇬🇧 Soft delete / 🇫🇷 Suppression douce
        $fiche->delete();

        return redirect()->route('admin.fiches.index')
            ->with('success', 'Fiche supprimée avec succès.');
    }
}