<?php

namespace App\Http\Controllers;

use App\Models\Fiche;
use App\Models\FichesCategory;
use Illuminate\Http\Request;

/**
 * 🇬🇧 PublicFicheController - Public display of fiches
 * 🇫🇷 PublicFicheController - Affichage public des fiches
 * 
 * @file app/Http/Controllers/PublicFicheController.php
 */
class PublicFicheController extends Controller
{
    /**
     * 🇬🇧 Display all categories
     * 🇫🇷 Afficher toutes les catégories
     */
    public function index()
    {
        $categories = FichesCategory::active()
            ->ordered()
            ->withCount(['publishedFiches'])
            ->get();

        $featuredFiches = Fiche::published()
            ->featured()
            ->visibleTo(auth()->user())
            ->with('category')
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
        if (!$category->is_active) {
            abort(404);
        }

        $fiches = Fiche::published()
            ->visibleTo(auth()->user())
            ->where('fiches_category_id', $category->id)
            ->with('category')
            ->ordered()
            ->paginate(12);

        return view('public.fiches.category', compact('category', 'fiches'));
    }

    /**
     * 🇬🇧 Display a single fiche
     * 🇫🇷 Afficher une fiche
     */
    public function show(FichesCategory $category, Fiche $fiche)
    {
        // 🇬🇧 Verify fiche belongs to category / 🇫🇷 Vérifier que la fiche appartient à la catégorie
        if ($fiche->fiches_category_id !== $category->id) {
            abort(404);
        }

        // 🇬🇧 Check if user can view / 🇫🇷 Vérifier si l'utilisateur peut voir
        if (!$fiche->canViewContent(auth()->user())) {
            if (!auth()->check()) {
                return redirect()->route('login')
                    ->with('info', 'Veuillez vous connecter pour accéder à cette fiche.');
            }
            
            abort(403, 'Accès non autorisé à cette fiche.');
        }

        // 🇬🇧 Increment views / 🇫🇷 Incrémenter les vues
        $fiche->incrementViews();

        // 🇬🇧 Load relationships / 🇫🇷 Charger les relations
        $fiche->load(['category', 'creator']);

        // 🇬🇧 Related fiches / 🇫🇷 Fiches associées
        $relatedFiches = Fiche::published()
            ->visibleTo(auth()->user())
            ->where('fiches_category_id', $category->id)
            ->where('id', '!=', $fiche->id)
            ->with('category')
            ->ordered()
            ->take(3)
            ->get();

        return view('public.fiches.show', compact('fiche', 'category', 'relatedFiches'));
    }
}