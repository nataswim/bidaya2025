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
        $query = Exercice::with(['category', 'sousCategory'])
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
        
        // Récupérer les exercices de cette catégorie
        $exercices = Exercice::where('exercice_category_id', $category->id)
            ->where('is_active', true)
            ->with(['sousCategory'])
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
        
        // Récupérer les exercices de cette sous-catégorie
        $exercices = Exercice::where('exercice_sous_category_id', $sousCategory->id)
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
        $exercice->load(['creator', 'category', 'sousCategory']);
        
        // Récupérer des exercices similaires
        // Priorité : même sous-catégorie > même catégorie > même type
        $exercicesSimilaires = Exercice::where('is_active', true)
            ->where('id', '!=', $exercice->id)
            ->when($exercice->exercice_sous_category_id, function($query) use ($exercice) {
                // Priorité 1 : même sous-catégorie
                $query->where('exercice_sous_category_id', $exercice->exercice_sous_category_id);
            }, function($query) use ($exercice) {
                // Priorité 2 : même catégorie
                if ($exercice->exercice_category_id) {
                    $query->where('exercice_category_id', $exercice->exercice_category_id);
                } elseif ($exercice->type_exercice) {
                    // Priorité 3 : même type (si pas de catégorie)
                    $query->where('type_exercice', $exercice->type_exercice);
                }
            })
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
            ->with(['category', 'sousCategory'])
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