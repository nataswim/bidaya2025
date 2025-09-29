<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlanPublicController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $niveau = $request->input('niveau');
        $objectif = $request->input('objectif');
        $duree = $request->input('duree');
        
        $query = Plan::where('is_public', true)
            ->where('is_active', true)
            ->with(['cycles']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($niveau) {
            $query->where('niveau', $niveau);
        }

        if ($objectif) {
            $query->where('objectif', $objectif);
        }

        if ($duree) {
            switch ($duree) {
                case 'courte':
                    $query->where('duree_semaines', '<=', 4);
                    break;
                case 'moyenne':
                    $query->whereBetween('duree_semaines', [5, 12]);
                    break;
                case 'longue':
                    $query->where('duree_semaines', '>', 12);
                    break;
            }
        }

        $plans = $query->orderBy('is_featured', 'desc')
            ->orderBy('ordre')
            ->orderBy('titre')
            ->paginate(12);

        // Plans en vedette pour la sidebar
        $plansFeatured = Plan::where('is_featured', true)
            ->where('is_public', true)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('public.plans.index', compact(
            'plans', 
            'plansFeatured', 
            'search', 
            'niveau', 
            'objectif', 
            'duree'
        ));
    }

    public function show(Plan $plan): RedirectResponse
    {
        // Vérifier que le plan est public et actif
        if (!$plan->is_public || !$plan->is_active) {
            abort(404, 'Plan non trouvé.');
        }

        // Vérifier si l'utilisateur est connecté et a les droits d'accès
        if (!auth()->check()) {
            // Rediriger vers login avec intention de retour
            return redirect()->route('login')
                ->with('intended', route('user.training.show', $plan))
                ->with('info', 'Connectez-vous pour accéder à ce plan d\'entraînement.');
        }

        $user = auth()->user();
        if (!($user->hasRole('user') || $user->hasRole('editor') || $user->hasRole('admin'))) {
            return redirect()->route('plans.index')
                ->with('error', 'Vous n\'avez pas accès aux plans d\'entraînement. Contactez un administrateur.');
        }

        // Rediriger vers la page utilisateur du plan
        return redirect()->route('user.training.show', $plan);
    }
}