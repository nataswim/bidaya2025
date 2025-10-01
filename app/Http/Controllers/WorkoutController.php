<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WorkoutCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;

/**
 * 🇬🇧 WorkoutController - Admin management for workouts
 * 🇫🇷 WorkoutController - Gestion admin des workouts
 * 
 * @file app/Http/Controllers/WorkoutController.php
 */
class WorkoutController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('editor')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $categoryId = $request->input('category');
        
        $query = Workout::with('categories');

        // 🇬🇧 Search filter / 🇫🇷 Filtrage par recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        // 🇬🇧 Category filter / 🇫🇷 Filtrage par catégorie
        if ($categoryId) {
            $query->whereHas('categories', function($q) use ($categoryId) {
                $q->where('workout_categories.id', $categoryId);
            });
        }

        $workouts = $query->orderBy('title', 'asc')
                          ->paginate(15);

        $categories = WorkoutCategory::with('section')
                                     ->active()
                                     ->ordered()
                                     ->get();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => Workout::count(),
            'categories_count' => WorkoutCategory::count(),
        ];

        return view('admin.workouts.index', compact(
            'workouts',
            'categories',
            'stats',
            'search',
            'categoryId'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = WorkoutCategory::with('section')
                                     ->active()
                                     ->ordered()
                                     ->get()
                                     ->groupBy('section.name');
        
        return view('admin.workouts.create', compact('categories'));
    }

    public function store(StoreWorkoutRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Extract categories and order numbers / 🇫🇷 Extraire les catégories et numéros d'ordre
        $categories = $data['categories'];
        $orderNumbers = $data['order_numbers'] ?? [];
        
        unset($data['categories'], $data['order_numbers']);
        
        // 🇬🇧 Create workout / 🇫🇷 Créer le workout
        $workout = Workout::create($data);

        // 🇬🇧 Attach categories with order numbers / 🇫🇷 Attacher les catégories avec numéros d'ordre
        $syncData = [];
        foreach ($categories as $index => $categoryId) {
            $orderNumber = $orderNumbers[$categoryId] ?? 0;
            $syncData[$categoryId] = ['order_number' => $orderNumber];
        }
        
        $workout->categories()->sync($syncData);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.workouts.edit', $workout)
                ->with('success', 'Workout créé avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.workouts.index')
            ->with('success', 'Workout créé avec succès.');
    }

    public function show(Workout $workout)
    {
        $this->checkAdminAccess();
        
        $workout->load('categories.section');
        
        return view('admin.workouts.show', compact('workout'));
    }

    public function edit(Workout $workout)
    {
        $this->checkAdminAccess();
        
        $categories = WorkoutCategory::with('section')
                                     ->active()
                                     ->ordered()
                                     ->get()
                                     ->groupBy('section.name');
        
        $workout->load('categories');
        
        return view('admin.workouts.edit', compact('workout', 'categories'));
    }

    public function update(UpdateWorkoutRequest $request, Workout $workout)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        // 🇬🇧 Extract categories and order numbers / 🇫🇷 Extraire les catégories et numéros d'ordre
        $categories = $data['categories'];
        $orderNumbers = $data['order_numbers'] ?? [];
        
        unset($data['categories'], $data['order_numbers']);
        
        // 🇬🇧 Update workout / 🇫🇷 Mettre à jour le workout
        $workout->update($data);

        // 🇬🇧 Sync categories with order numbers / 🇫🇷 Synchroniser les catégories avec numéros d'ordre
        $syncData = [];
        foreach ($categories as $index => $categoryId) {
            $orderNumber = $orderNumbers[$categoryId] ?? 0;
            $syncData[$categoryId] = ['order_number' => $orderNumber];
        }
        
        $workout->categories()->sync($syncData);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.workouts.edit', $workout)
                ->with('success', 'Workout mis à jour avec succès.');
        }

        return redirect()->route('admin.workouts.index')
            ->with('success', 'Workout mis à jour avec succès.');
    }

    public function destroy(Workout $workout)
    {
        $this->checkAdminAccess();
        
        // 🇬🇧 Detach categories / 🇫🇷 Détacher les catégories
        $workout->categories()->detach();
        
        // 🇬🇧 Soft delete / 🇫🇷 Suppression douce
        $workout->delete();

        return redirect()->route('admin.workouts.index')
            ->with('success', 'Workout supprimé avec succès.');
    }
}