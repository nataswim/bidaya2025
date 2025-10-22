<?php

namespace App\Http\Controllers;

use App\Models\ExerciceCategory;
use App\Models\ExerciceSousCategory;
use Illuminate\View\View;

class AnatomyController extends Controller
{
    /**
     * Afficher la carte anatomique interactive
     */
    public function index(): View
    {
        // Récupérer toutes les sous-catégories actives pour le mapping
        $sousCategories = ExerciceSousCategory::active()
            ->with('category')
            ->withCount('exercices')
            ->get()
            ->keyBy('slug');
        
        return view('anatomy.index', compact('sousCategories'));
    }
}