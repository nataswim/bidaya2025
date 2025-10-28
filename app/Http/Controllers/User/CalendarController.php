<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventLinkable;
use App\Models\Workout;
use App\Models\WorkoutSection;
use App\Models\WorkoutCategory;
use App\Models\Exercice;
use App\Models\ExerciceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    // Vérifier l'accès premium
    private function checkPremiumAccess()
    {
        $user = auth()->user();

        if (!$user->hasRole('user') && !$user->hasRole('editor') && !$user->hasRole('admin')) {
            abort(403, 'Cette fonctionnalité est réservée aux membres premium');
        }
    }

    /**
     * Liste des événements (vue liste chronologique)
     */
    public function index(Request $request)
    {
        $this->checkPremiumAccess();

        $query = Event::forUser(auth()->id());

        // Filtres
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Événements de cette semaine
        $thisWeekEvents = Event::forUser(auth()->id())
            ->thisWeek()
            ->planned()
            ->get();

        // Événements à venir (après cette semaine)
        $upcomingEvents = Event::forUser(auth()->id())
            ->upcoming()
            ->where('event_date', '>', now()->endOfWeek())
            ->get();

        // Événements passés à compléter
        $needsCompletion = Event::forUser(auth()->id())
            ->needsCompletion()
            ->get();

        // Événements passés complétés
        $pastEvents = Event::forUser(auth()->id())
            ->past()
            ->completed()
            ->limit(20)
            ->get();

        // Statistiques du mois
        $monthStats = $this->getMonthStatistics();

        return view('user.calendar.index', compact(
            'thisWeekEvents',
            'upcomingEvents',
            'needsCompletion',
            'pastEvents',
            'monthStats'
        ));
    }









    /**
     * Afficher le formulaire de création
     */
    public function create(Request $request)
    {
        $this->checkPremiumAccess();

        return view('user.calendar.create');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        // Charger les relations pour pré-sélection
        $event->load([
            'linkables.linkable',
            'workouts.linkable',
            'exercices.linkable'
        ]);

        return view('user.calendar.edit', compact('event'));
    }


    /**
     * Créer un événement (planification) - MODIFIÉ
     */
    public function store(Request $request)
    {
        $this->checkPremiumAccess();

        $validated = $request->validate([
            'discipline' => 'nullable|string|max:200',
            'title' => 'required|string|max:200',
            'objective' => 'nullable|string|max:200',
            'type' => 'required|in:entrainement,rendez-vous,stage,competition,autres',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:200',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
            'material' => 'nullable|string',
            'planned_duration' => 'nullable|string|max:50',
            'planned_distance' => 'nullable|string|max:50',

            // NOUVEAU : Contenus liés
            'workout_id' => 'nullable|exists:workouts,id',
            'exercice_ids' => 'nullable|array',
            'exercice_ids.*' => 'exists:exercices,id',
        ]);

        // Définir la couleur selon le type
        $validated['color'] = match ($validated['type']) {
            'entrainement' => '#007bff',
            'rendez-vous' => '#6c757d',
            'stage' => '#fd7e14',
            'competition' => '#ffc107',
            'autres' => '#6f42c1',
            default => '#007bff'
        };

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'planned';

        // Créer l'événement dans une transaction
        DB::beginTransaction();
        try {
            // Créer l'événement
            $event = Event::create($validated);

            // Lier le workout si présent
            if (!empty($validated['workout_id'])) {
                EventLinkable::create([
                    'event_id' => $event->id,
                    'linkable_type' => \App\Models\Workout::class,
                    'linkable_id' => $validated['workout_id'],
                    'order' => 0,
                ]);
            }

            // Lier les exercices si présents
            if (!empty($validated['exercice_ids']) && is_array($validated['exercice_ids'])) {
                foreach ($validated['exercice_ids'] as $index => $exerciceId) {
                    EventLinkable::create([
                        'event_id' => $event->id,
                        'linkable_type' => \App\Models\Exercice::class,
                        'linkable_id' => $exerciceId,
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'event' => $event->load('linkables.linkable'),
                    'message' => 'Activité planifiée avec succès'
                ]);
            }

            return redirect()->route('user.calendar.index')
                ->with('success', 'Activité planifiée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur création événement', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création'
                ], 500);
            }

            return back()->withErrors(['error' => 'Erreur lors de la création'])->withInput();
        }
    }

    /**
     * Afficher un événement - MODIFIÉ
     */
    public function show(Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        // Charger toutes les relations
        $event->load([
            'linkables.linkable',
            'workouts.linkable',
            'exercices.linkable'
        ]);

        return view('user.calendar.show', compact('event'));
    }

    // ========== NOUVELLES MÉTHODES API ==========

    /**
     * API : Obtenir les sections de workout
     */
    public function getWorkoutSections()
    {
        $this->checkPremiumAccess();

        try {
            $sections = WorkoutSection::active()
                ->ordered()
                ->get(['id', 'name', 'slug'])
                ->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                        'slug' => $section->slug,
                    ];
                });

            return response()->json($sections);
        } catch (\Exception $e) {
            \Log::error('Erreur getWorkoutSections', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors du chargement'], 500);
        }
    }

    /**
     * API : Obtenir les catégories d'une section
     */
    public function getWorkoutCategories(Request $request, $sectionId)
    {
        $this->checkPremiumAccess();

        try {
            $categories = WorkoutCategory::where('workout_section_id', $sectionId)
                ->active()
                ->ordered()
                ->get(['id', 'name', 'slug'])
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ];
                });

            return response()->json($categories);
        } catch (\Exception $e) {
            \Log::error('Erreur getWorkoutCategories', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors du chargement'], 500);
        }
    }

    /**
     * API : Obtenir les workouts d'une catégorie
     */
    public function getWorkouts(Request $request, $categoryId)
    {
        $this->checkPremiumAccess();

        try {
            $category = WorkoutCategory::findOrFail($categoryId);

            $workouts = $category->workouts()
                ->get(['workouts.id', 'workouts.title', 'workouts.slug'])
                ->map(function ($workout) {
                    return [
                        'id' => $workout->id,
                        'title' => $workout->title,
                        'slug' => $workout->slug,
                    ];
                });

            return response()->json($workouts);
        } catch (\Exception $e) {
            \Log::error('Erreur getWorkouts', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors du chargement'], 500);
        }
    }

    /**
     * API : Obtenir les catégories d'exercices
     */
    public function getExerciceCategories()
    {
        $this->checkPremiumAccess();

        try {
            $categories = ExerciceCategory::active()
                ->ordered()
                ->get(['id', 'name', 'slug'])
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ];
                });

            return response()->json($categories);
        } catch (\Exception $e) {
            \Log::error('Erreur getExerciceCategories', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors du chargement'], 500);
        }
    }

    /**
     * API : Obtenir les exercices (tous ou par catégorie)
     */
    public function getExercices(Request $request, $categoryId = null)
    {
        $this->checkPremiumAccess();

        try {
            if ($categoryId) {
                // Exercices d'une catégorie spécifique
                $category = ExerciceCategory::findOrFail($categoryId);
                $exercices = $category->exercices()
                    ->active()
                    ->ordered()
                    ->get();
            } else {
                // Tous les exercices actifs
                $exercices = Exercice::active()
                    ->ordered()
                    ->limit(100)
                    ->get();
            }

            $exercices = $exercices->map(function ($exercice) {
                return [
                    'id' => $exercice->id,
                    'titre' => $exercice->titre,
                    'niveau' => $exercice->niveau_label ?? '',
                    'type' => $exercice->type_exercice_label ?? '',
                ];
            });

            return response()->json($exercices);
        } catch (\Exception $e) {
            \Log::error('Erreur getExercices', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erreur lors du chargement'], 500);
        }
    }




    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'discipline' => 'nullable|string|max:200',
            'title' => 'required|string|max:200',
            'objective' => 'nullable|string|max:200',
            'type' => 'required|in:entrainement,rendez-vous,stage,competition,autres',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:200',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
            'material' => 'nullable|string',
            'planned_duration' => 'nullable|string|max:50',
            'planned_distance' => 'nullable|string|max:50',

            // NOUVEAU : Contenus liés (modifiables)
            'workout_id' => 'nullable|exists:workouts,id',
            'exercice_ids' => 'nullable|array',
            'exercice_ids.*' => 'exists:exercices,id',
        ]);

        // Mettre à jour la couleur selon le type
        $validated['color'] = match ($validated['type']) {
            'entrainement' => '#007bff',
            'rendez-vous' => '#6c757d',
            'stage' => '#fd7e14',
            'competition' => '#ffc107',
            'autres' => '#6f42c1',
            default => '#007bff'
        };

        // Transaction pour tout mettre à jour
        DB::beginTransaction();
        try {
            // Mettre à jour l'événement
            $event->update($validated);

            // SUPPRIMER tous les anciens liens
            $event->linkables()->delete();

            // CRÉER les nouveaux liens - Workout
            if (!empty($validated['workout_id'])) {
                EventLinkable::create([
                    'event_id' => $event->id,
                    'linkable_type' => \App\Models\Workout::class,
                    'linkable_id' => $validated['workout_id'],
                    'order' => 0,
                ]);
            }

            // CRÉER les nouveaux liens - Exercices
            if (!empty($validated['exercice_ids']) && is_array($validated['exercice_ids'])) {
                foreach ($validated['exercice_ids'] as $index => $exerciceId) {
                    EventLinkable::create([
                        'event_id' => $event->id,
                        'linkable_type' => \App\Models\Exercice::class,
                        'linkable_id' => $exerciceId,
                        'order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'event' => $event->load('linkables.linkable'),
                    'message' => 'Activité modifiée avec succès'
                ]);
            }

            return redirect()->route('user.calendar.show', $event)
                ->with('success', 'Activité modifiée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur mise à jour événement', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la modification'
                ], 500);
            }

            return back()->withErrors(['error' => 'Erreur lors de la modification'])->withInput();
        }
    }

    /**
     * Finaliser un événement (après réalisation)
     */
    public function complete(Request $request, Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'effort_feeling' => 'required|integer|min:1|max:10',
            'objective_achieved' => 'required|in:not_achieved,achieved,exceeded',
            'actual_duration' => 'nullable|string|max:50',
            'actual_distance' => 'nullable|string|max:50',
            'weather_conditions' => 'nullable|in:sunny,cloudy,rainy,windy,cold,hot',
            'pain_discomfort' => 'nullable|string',
        ]);

        $validated['status'] = 'completed';

        $event->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Activité finalisée avec succès'
        ]);
    }

    /**
     * Annuler un événement
     */
    public function cancel(Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Activité annulée'
        ]);
    }

    /**
     * Supprimer un événement
     */
    public function destroy(Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('user.calendar.index')
            ->with('success', 'Activité supprimée');
    }

    /**
     * Obtenir le nombre d'événements de la semaine (pour le badge)
     */
    public function weekCount()
    {
        $this->checkPremiumAccess();

        $count = Event::forUser(auth()->id())
            ->thisWeek()
            ->planned()
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Statistiques du mois
     */
    private function getMonthStatistics()
    {
        $events = Event::forUser(auth()->id())
            ->whereBetween('event_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->completed()
            ->get();

        return [
            'total_completed' => $events->count(),
            'average_effort' => $events->avg('effort_feeling') ? round($events->avg('effort_feeling'), 1) : 0,
            'objectives_achieved' => $events->where('objective_achieved', 'achieved')->count() + $events->where('objective_achieved', 'exceeded')->count(),
            'objectives_total' => $events->whereNotNull('objective_achieved')->count(),
            'objectives_percentage' => $events->whereNotNull('objective_achieved')->count() > 0
                ? round((($events->where('objective_achieved', 'achieved')->count() + $events->where('objective_achieved', 'exceeded')->count()) / $events->whereNotNull('objective_achieved')->count()) * 100)
                : 0,
        ];
    }

    /**
     * Créer un événement depuis un workout
     */
    public function createFromWorkout(Workout $workout)
    {
        $this->checkPremiumAccess();

        return response()->json([
            'success' => true,
            'workout' => [
                'id' => $workout->id,
                'title' => $workout->title,
                'type' => 'workout',
            ]
        ]);
    }

    /**
     * Créer un événement depuis un plan
     */
    public function createFromPlan(Plan $plan)
    {
        $this->checkPremiumAccess();

        return response()->json([
            'success' => true,
            'plan' => [
                'id' => $plan->id,
                'title' => $plan->titre,
                'type' => 'plan',
            ]
        ]);
    }


    /**
     * API pour obtenir les contenus linkables (workout/plan)
     */
    /**
     * API pour obtenir les contenus linkables (workout/plan)
     */
    public function getLinkable(Request $request, $type)
    {
        $this->checkPremiumAccess();

        try {
            if ($type === 'workout') {
                // Vérifier les colonnes disponibles dans le modèle Workout
                // Adapter selon votre structure de base de données
                $items = \App\Models\Workout::query()
                    ->select('id', 'title') // Ou 'name' si c'est le nom de la colonne
                    ->orderBy('title')
                    ->limit(100) // Limiter pour éviter trop de résultats
                    ->get()
                    ->map(function ($workout) {
                        return [
                            'id' => $workout->id,
                            'title' => $workout->title ?? $workout->name ?? 'Sans titre'
                        ];
                    });
            } elseif ($type === 'plan') {
                $items = \App\Models\Plan::query()
                    ->select('id', 'titre')
                    ->orderBy('titre')
                    ->limit(100)
                    ->get()
                    ->map(function ($plan) {
                        return [
                            'id' => $plan->id,
                            'title' => $plan->titre ?? 'Sans titre'
                        ];
                    });
            } else {
                return response()->json([]);
            }

            return response()->json($items);
        } catch (\Exception $e) {
            \Log::error('Erreur getLinkable', [
                'type' => $type,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'error' => 'Erreur lors du chargement des contenus',
                'message' => config('app.debug') ? $e->getMessage() : 'Erreur serveur'
            ], 500);
        }
    }
}
