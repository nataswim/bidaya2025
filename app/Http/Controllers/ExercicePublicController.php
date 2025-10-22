<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Models\ExerciceCategory;
use App\Models\ExerciceSousCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExercicePublicController extends Controller
{
    /**
     * Afficher la liste des exercices avec catégories
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        
        // Récupérer les catégories actives avec comptage
        $categories = ExerciceCategory::active()
            ->ordered()
            ->withCount('exercices')
            ->get();
        
        // Query de base pour les exercices
        $query = Exercice::with(['categories', 'sousCategories'])
            ->where('is_active', true)
            ->orderBy('ordre')
            ->orderBy('titre');
        
        // Appliquer la recherche si présente
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Récupérer les exercices paginés
        $exercices = $query->paginate(12);
        
        return view('public.exercices.index', compact('exercices', 'categories', 'search'));
    }
    
    /**
     * Afficher les exercices d'une catégorie
     */
    public function category(ExerciceCategory $category): View
    {
        // Vérifier si la catégorie est active
        if (!$category->is_active) {
            abort(404);
        }
        
        // Récupérer les sous-catégories de cette catégorie
        $sousCategories = ExerciceSousCategory::where('exercice_category_id', $category->id)
            ->active()
            ->ordered()
            ->withCount('exercices')
            ->get();
        
        // Récupérer les exercices liés à cette catégorie via la table pivot
        $exercices = Exercice::whereHas('categories', function($query) use ($category) {
                $query->where('exercice_categories.id', $category->id);
            })
            ->where('is_active', true)
            ->with(['sousCategories'])
            ->orderBy('ordre')
            ->orderBy('titre')
            ->paginate(12);
        
        return view('public.exercices.category', compact('category', 'sousCategories', 'exercices'));
    }
    
    /**
     * Afficher les exercices d'une sous-catégorie
     */
    public function sousCategory(ExerciceCategory $category, ExerciceSousCategory $sousCategory): View
    {
        // Vérifier si la catégorie et sous-catégorie sont actives
        if (!$category->is_active || !$sousCategory->is_active) {
            abort(404);
        }
        
        // Vérifier que la sous-catégorie appartient bien à la catégorie
        if ($sousCategory->exercice_category_id !== $category->id) {
            abort(404);
        }
        
        // Récupérer les exercices liés à cette sous-catégorie via la table pivot
        $exercices = Exercice::whereHas('sousCategories', function($query) use ($sousCategory) {
                $query->where('exercice_sous_categories.id', $sousCategory->id);
            })
            ->where('is_active', true)
            ->orderBy('ordre')
            ->orderBy('titre')
            ->paginate(12);
        
        return view('public.exercices.sous-category', compact('category', 'sousCategory', 'exercices'));
    }
    
    /**
     * Afficher un exercice spécifique
     */
    public function show(Exercice $exercice): View
    {
        // Vérifier que l'exercice est actif
        if (!$exercice->is_active) {
            abort(404, 'Exercice non trouvé.');
        }
        
        // Charger les relations nécessaires
        $exercice->load(['creator', 'categories', 'sousCategories']);
        
        // Récupérer la première catégorie pour compatibilité breadcrumb
        $exercice->category = $exercice->categories->first();
        $exercice->sousCategory = $exercice->sousCategories->first();
        
        // Récupérer des exercices similaires
        $exercicesSimilaires = Exercice::where('is_active', true)
            ->where('id', '!=', $exercice->id)
            ->where(function($query) use ($exercice) {
                // Exercices qui partagent au moins une catégorie
                if ($exercice->categories->isNotEmpty()) {
                    $categoryIds = $exercice->categories->pluck('id');
                    $query->whereHas('categories', function($q) use ($categoryIds) {
                        $q->whereIn('exercice_categories.id', $categoryIds);
                    });
                }
                // Ou même type d'exercice
                elseif ($exercice->type_exercice) {
                    $query->orWhere('type_exercice', $exercice->type_exercice);
                }
            })
            ->with(['categories', 'sousCategories'])
            ->orderBy('ordre')
            ->orderBy('titre')
            ->limit(6)
            ->get();
        
        return view('public.exercices.show', compact('exercice', 'exercicesSimilaires'));
    }
    
    /**
     * Recherche d'exercices
     */
    public function search(Request $request): View
    {
        $search = $request->input('q', '');
        
        $exercices = Exercice::where('is_active', true)
            ->with(['categories', 'sousCategories'])
            ->where(function($query) use ($search) {
                $query->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('ordre')
            ->orderBy('titre')
            ->paginate(12);

        return view('public.exercices.search', compact('exercices', 'search'));
    }
}