<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Workout;
use App\Models\Plan;
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
     * Créer un événement (planification)
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
            'linkable_type' => 'nullable|in:workout,plan',
            'linkable_id' => 'nullable|integer',
        ]);

        // Mapper le linkable_type vers la classe du modèle
        if ($validated['linkable_type'] ?? false) {
            $validated['linkable_type'] = match ($validated['linkable_type']) {
                'workout' => \App\Models\Workout::class,
                'plan' => \App\Models\Plan::class,
                default => null
            };
        }

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

        $event = Event::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'event' => $event,
                'message' => 'Activité planifiée avec succès'
            ]);
        }

        return redirect()->route('user.calendar.index')
            ->with('success', 'Activité planifiée avec succès');
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

        return view('user.calendar.edit', compact('event'));
    }


    /**
     * Afficher un événement
     */
    public function show(Event $event)
    {
        $this->checkPremiumAccess();

        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->load('linkable');

        return view('user.calendar.show', compact('event'));
    }

    /**
     * Mettre à jour un événement (modification planification)
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
        ]);

        // Mettre à jour la couleur si le type change
        $validated['color'] = match ($validated['type']) {
            'entrainement' => '#007bff',
            'rendez-vous' => '#6c757d',
            'stage' => '#fd7e14',
            'competition' => '#ffc107',
            'autres' => '#6f42c1',
            default => '#007bff'
        };

        $event->update($validated);

        return redirect()->route('user.calendar.index')
            ->with('success', 'Activité mise à jour');
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
