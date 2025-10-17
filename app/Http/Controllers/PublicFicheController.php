<?php

namespace App\Http\Controllers;

use App\Models\Fiche;
use App\Models\FichesCategory;
use App\Models\FichesSousCategory;
use Illuminate\Http\Request;

/**
 * 🇬🇧 PublicFicheController - Public fiches display
 * 🇫🇷 PublicFicheController - Affichage public des fiches
 * 
 * @file app/Http/Controllers/PublicFicheController.php
 */
class PublicFicheController extends Controller
{
    /**
     * 🇬🇧 Display all categories with featured fiches
     * 🇫🇷 Afficher toutes les catégories avec les fiches en vedette
     */
    public function index()
    {
        // 🇬🇧 Get all active categories with sub-categories / 🇫🇷 Récupérer toutes les catégories actives avec sous-catégories
        $categories = FichesCategory::active()
            ->with(['activeSousCategories'])
            ->withCount(['publishedFiches'])
            ->ordered()
            ->get();

        // 🇬🇧 Get featured fiches / 🇫🇷 Récupérer les fiches en vedette
        $featuredFiches = Fiche::published()
            ->featured()
            ->visibleTo(auth()->user())
            ->with(['category', 'sousCategory'])
            ->ordered()
            ->take(6)
            ->get();

        return view('public.fiches.index', compact('categories', 'featuredFiches'));
    }

    /**
     * 🇬🇧 Display fiches by category
     * 🇫🇷 Afficher les fiches par catégorie
     */
    public function category(FichesCategory $category)
    {
        // 🇬🇧 Get fiches of this category / 🇫🇷 Récupérer les fiches de cette catégorie
        $fiches = Fiche::published()
            ->visibleTo(auth()->user())
            ->byCategory($category->id)
            ->with(['category', 'sousCategory'])
            ->ordered()
            ->paginate(12);

        // 🇬🇧 Get active sub-categories / 🇫🇷 Récupérer les sous-catégories actives
        $sousCategories = $category->activeSousCategories()
            ->withCount('publishedFiches')
            ->get();

        return view('public.fiches.category', compact('category', 'fiches', 'sousCategories'));
    }

    /**
     * 🇬🇧 Display fiches by sub-category
     * 🇫🇷 Afficher les fiches par sous-catégorie
     */
    public function sousCategory(FichesCategory $category, FichesSousCategory $sousCategory)
    {
        // 🇬🇧 Verify sub-category belongs to category / 🇫🇷 Vérifier que la sous-catégorie appartient à la catégorie
        if ($sousCategory->fiches_category_id !== $category->id) {
            abort(404, 'La sous-catégorie ne correspond pas à la catégorie.');
        }

        // 🇬🇧 Get fiches of this sub-category / 🇫🇷 Récupérer les fiches de cette sous-catégorie
        $fiches = Fiche::published()
            ->visibleTo(auth()->user())
            ->bySousCategory($sousCategory->id)
            ->with(['category', 'sousCategory'])
            ->ordered()
            ->paginate(12);

        return view('public.fiches.sous-category', compact('category', 'sousCategory', 'fiches'));
    }

    /**
     * 🇬🇧 Display a single fiche
     * 🇫🇷 Afficher une fiche individuelle
     */
    public function show(FichesCategory $category, Fiche $fiche)
    {
        // 🇬🇧 Verify fiche belongs to category / 🇫🇷 Vérifier que la fiche appartient à la catégorie
        if ($fiche->fiches_category_id !== $category->id) {
            abort(404, 'La fiche ne correspond pas à la catégorie.');
        }

        // 🇬🇧 Check if user can view content / 🇫🇷 Vérifier si l'utilisateur peut voir le contenu
        if (!$fiche->canViewContent(auth()->user())) {
            if (auth()->check()) {
                abort(403, 'Vous n\'avez pas accès à cette fiche.');
            }
            
            return redirect()->route('login')
                ->with('info', 'Veuillez vous connecter pour accéder à cette fiche.');
        }

        // 🇬🇧 Load relationships / 🇫🇷 Charger les relations
        $fiche->load(['category', 'sousCategory', 'creator']);
        
        // 🇬🇧 Increment views count / 🇫🇷 Incrémenter le compteur de vues
        $fiche->incrementViews();

        // 🇬🇧 Get related fiches (same sub-category or same category) / 🇫🇷 Récupérer les fiches associées
        $relatedFiches = Fiche::published()
            ->visibleTo(auth()->user())
            ->where('id', '!=', $fiche->id)
            ->where(function($query) use ($fiche) {
                // 🇬🇧 Prioritize same sub-category, then same category / 🇫🇷 Prioriser la même sous-catégorie, puis la même catégorie
                if ($fiche->fiches_sous_category_id) {
                    $query->where('fiches_sous_category_id', $fiche->fiches_sous_category_id)
                          ->orWhere(function($q) use ($fiche) {
                              $q->whereNull('fiches_sous_category_id')
                                ->where('fiches_category_id', $fiche->fiches_category_id);
                          });
                } else {
                    $query->where('fiches_category_id', $fiche->fiches_category_id);
                }
            })
            ->with(['category', 'sousCategory'])
            ->ordered()
            ->take(3)
            ->get();

        return view('public.fiches.show', compact('fiche', 'relatedFiches', 'category'));
    }
}