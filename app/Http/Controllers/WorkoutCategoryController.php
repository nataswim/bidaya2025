<?php

namespace App\Http\Controllers;

use App\Models\WorkoutCategory;
use App\Models\WorkoutSection;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorkoutCategoryRequest;
use App\Http\Requests\UpdateWorkoutCategoryRequest;

/**
 * 🇬🇧 WorkoutCategoryController - Admin management for workout categories
 * 🇫🇷 WorkoutCategoryController - Gestion admin des catégories de workout
 * 
 * @file app/Http/Controllers/WorkoutCategoryController.php
 */
class WorkoutCategoryController extends Controller
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
        $sectionId = $request->input('section');
        
        $query = WorkoutCategory::with('section');

        // 🇬🇧 Search filter / 🇫🇷 Filtrage par recherche
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // 🇬🇧 Section filter / 🇫🇷 Filtrage par section
        if ($sectionId) {
            $query->where('workout_section_id', $sectionId);
        }

        $categories = $query->withCount('workouts')
                           ->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(15);

        $sections = WorkoutSection::active()->ordered()->get();

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => WorkoutCategory::count(),
            'active' => WorkoutCategory::where('is_active', true)->count(),
            'inactive' => WorkoutCategory::where('is_active', false)->count(),
        ];

        return view('admin.workout-categories.index', compact(
            'categories',
            'sections',
            'stats',
            'search',
            'sectionId'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $sections = WorkoutSection::active()->ordered()->get();
        
        return view('admin.workout-categories.create', compact('sections'));
    }

    public function store(StoreWorkoutCategoryRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        WorkoutCategory::create($data);

        return redirect()->route('admin.workout-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(WorkoutCategory $workoutCategory)
    {
        $this->checkAdminAccess();
        
        $workoutCategory->load(['section', 'workouts']);
        $workoutCategory->loadCount('workouts');
        
        return view('admin.workout-categories.show', compact('workoutCategory'));
    }

    public function edit(WorkoutCategory $workoutCategory)
    {
        $this->checkAdminAccess();
        
        $sections = WorkoutSection::active()->ordered()->get();
        
        return view('admin.workout-categories.edit', compact('workoutCategory', 'sections'));
    }

    public function update(UpdateWorkoutCategoryRequest $request, WorkoutCategory $workoutCategory)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $workoutCategory->update($data);

        return redirect()->route('admin.workout-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(WorkoutCategory $workoutCategory)
    {
        $this->checkAdminAccess();
        
        // 🇬🇧 Check if category has workouts / 🇫🇷 Vérifier si la catégorie a des workouts
        if ($workoutCategory->workouts()->count() > 0) {
            return redirect()->route('admin.workout-categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des workouts.');
        }
        
        // 🇬🇧 Soft delete / 🇫🇷 Suppression douce
        $workoutCategory->delete();

        return redirect()->route('admin.workout-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}