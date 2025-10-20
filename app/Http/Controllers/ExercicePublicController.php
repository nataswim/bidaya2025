<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExercicePublicController extends Controller
{
    
    
    
    
    public function index(Request $request): View
{
    $search = $request->input('search');
    
    $query = Exercice::where('is_active', true)->orderBy('ordre')->orderBy('titre');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $exercices = $query->paginate(12);

    return view('public.exercices.index', compact('exercices', 'search'));
}

public function show(Exercice $exercice): View
{
    // Vérifier que l'exercice est actif
    if (!$exercice->is_active) {
        abort(404, 'Exercice non trouvé.');
    }

    // Charger les relations nécessaires
    $exercice->load(['creator']);

    // Exercices similaires - chercher par type SI le type existe
    $exercicesSimilaires = Exercice::where('is_active', true)
        ->where('id', '!=', $exercice->id);
    
    if ($exercice->type_exercice) {
        $exercicesSimilaires->where('type_exercice', $exercice->type_exercice);
    }
    
    $exercicesSimilaires = $exercicesSimilaires->limit(4)->get();

    return view('public.exercices.show', compact('exercice', 'exercicesSimilaires'));
}



    public function search(Request $request): View
    {
        $search = $request->input('q', '');
        
        $exercices = Exercice::where('is_active', true)
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