<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Exercice;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrainingController extends Controller
{
    private function checkTrainingAccess()
    {
        if (!auth()->check()) {
            abort(403, 'Connexion requise pour accéder aux plans d\'entraînement.');
        }
        
        $user = auth()->user();
        if (!($user->hasRole('user') || $user->hasRole('editor') || $user->hasRole('admin'))) {
            abort(403, 'Accès aux plans d\'entraînement non autorisé. Rôle utilisateur requis.');
        }
    }

    // Alias pour compatibilité
    private function checkUserAccess()
    {
        $this->checkTrainingAccess();
    }



   public function index(Request $request): View
    {
        $this->checkTrainingAccess();
        
        $search = $request->input('search');
        $niveau = $request->input('niveau');
        $objectif = $request->input('objectif');
        
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

        $plans = $query->orderBy('ordre')->orderBy('titre')->paginate(12);

        // Plans assignés à l'utilisateur
        $mesPlans = auth()->user()->plans()
            ->wherePivot('statut', '!=', 'abandonne')
            ->with(['cycles'])
            ->get();

        // Plans en vedette
        $plansFeatured = Plan::where('is_featured', true)
            ->where('is_public', true)
            ->where('is_active', true)
            ->with(['cycles'])
            ->limit(3)
            ->get();

        return view('user.training.index', compact('plans', 'mesPlans', 'plansFeatured', 'search', 'niveau', 'objectif'));
    }





    public function show(Plan $plan): View
    {
        $this->checkTrainingAccess();
        
        // Vérifier la visibilité
        if (!$plan->is_public && !auth()->user()->hasRole('admin')) {
            abort(404, 'Plan non trouvé.');
        }

        $plan->load(['cycles.seances.series.exercice']);
        
        // Vérifier si l'utilisateur a ce plan assigné
        $userPlan = $plan->users()->where('user_id', auth()->id())->first();

        return view('user.training.show', compact('plan', 'userPlan'));
    }



    public function cycle(Plan $plan, $cycleId): View
    {
        $this->checkTrainingAccess();
        
        if (!$plan->is_public && !auth()->user()->hasRole('admin')) {
            abort(404, 'Plan non trouvé.');
        }

        $cycle = $plan->cycles()->where('cycles.id', $cycleId)->firstOrFail();
        $cycle->load(['seances.series.exercice']);
        
        $userPlan = $plan->users()->where('user_id', auth()->id())->first();

        return view('user.training.cycle', compact('plan', 'cycle', 'userPlan'));
    }



    public function seance(Plan $plan, $cycleId, $seanceId): View
    {
        $this->checkTrainingAccess();
        
        if (!$plan->is_public && !auth()->user()->hasRole('admin')) {
            abort(404, 'Plan non trouvé.');
        }

        $cycle = $plan->cycles()->where('cycles.id', $cycleId)->firstOrFail();
        $seance = $cycle->seances()->where('seances.id', $seanceId)->firstOrFail();
        $seance->load(['series.exercice']);
        
        $userPlan = $plan->users()->where('user_id', auth()->id())->first();

        return view('user.training.seance', compact('plan', 'cycle', 'seance', 'userPlan'));
    }

    public function exercice(Exercice $exercice): View
    {
        // Les exercices sont publics, pas besoin de vérification d'accès
        if (!$exercice->is_active) {
            abort(404, 'Exercice non trouvé.');
        }

        return view('user.training.exercice', compact('exercice'));
    }

    
    public function commencer(Plan $plan): RedirectResponse
    {
        $this->checkUserAccess();
        
        if (!$plan->is_public) {
            abort(404, 'Plan non trouvé.');
        }

        // Vérifier si déjà assigné
        if ($plan->isAssignedToUser(auth()->id())) {
            return redirect()->route('user.training.show', $plan)
                ->with('info', 'Vous suivez déjà ce plan d\'entraînement.');
        }

        $dateDebut = now();
        $dateFinPrevue = $plan->duree_semaines ? $dateDebut->copy()->addWeeks($plan->duree_semaines) : null;

        $plan->users()->attach(auth()->id(), [
            'date_debut' => $dateDebut,
            'date_fin_prevue' => $dateFinPrevue,
            'statut' => 'en_cours',
            'progression_pourcentage' => 0,
            'assigned_by' => null, // Auto-assignation
        ]);

        return redirect()->route('user.training.show', $plan)
            ->with('success', 'Plan d\'entraînement commencé avec succès !');
    }

    public function updateStatut(Request $request, Plan $plan): RedirectResponse
    {
        $this->checkUserAccess();
        
        $validated = $request->validate([
            'statut' => 'required|in:en_cours,pause,termine,abandonne',
            'notes_utilisateur' => 'nullable|string|max:1000',
            'progression_pourcentage' => 'nullable|integer|min:0|max:100',
        ]);

        $userPlan = $plan->getUserAssignment(auth()->id());
        if (!$userPlan) {
            abort(404, 'Plan non assigné.');
        }

        $plan->users()->updateExistingPivot(auth()->id(), [
            'statut' => $validated['statut'],
            'notes_utilisateur' => $validated['notes_utilisateur'] ?? $userPlan->pivot->notes_utilisateur,
            'progression_pourcentage' => $validated['progression_pourcentage'] ?? $userPlan->pivot->progression_pourcentage,
        ]);

        $message = match($validated['statut']) {
            'pause' => 'Plan mis en pause.',
            'termine' => 'Félicitations ! Plan terminé avec succès !',
            'abandonne' => 'Plan abandonné.',
            'en_cours' => 'Plan repris.',
            default => 'Statut mis à jour.'
        };

        return redirect()->route('user.training.show', $plan)
            ->with('success', $message);
    }

    public function mesPlans(): View
    {
        $this->checkTrainingAccess();
        
        $mesPlans = auth()->user()->plans()
            ->with(['cycles.seances'])
            ->orderBy('user_plans.created_at', 'desc')
            ->get();

        return view('user.training.mes-plans', compact('mesPlans'));
    }

}