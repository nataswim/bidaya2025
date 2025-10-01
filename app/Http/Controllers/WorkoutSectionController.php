<?php

namespace App\Http\Controllers;

use App\Models\WorkoutSection;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWorkoutSectionRequest;
use App\Http\Requests\UpdateWorkoutSectionRequest;

/**
 * 🇬🇧 WorkoutSectionController - Admin management for workout sections
 * 🇫🇷 WorkoutSectionController - Gestion admin des sections de workout
 * 
 * @file app/Http/Controllers/WorkoutSectionController.php
 */
class WorkoutSectionController extends Controller
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
        $query = WorkoutSection::query();

        // 🇬🇧 Search filter / 🇫🇷 Filtrage par recherche
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $sections = $query->withCount('categories')
                          ->orderBy('sort_order', 'asc')
                          ->orderBy('name', 'asc')
                          ->paginate(15);

        // 🇬🇧 Statistics / 🇫🇷 Statistiques
        $stats = [
            'total' => WorkoutSection::count(),
            'active' => WorkoutSection::where('is_active', true)->count(),
            'inactive' => WorkoutSection::where('is_active', false)->count(),
        ];

        return view('admin.workout-sections.index', compact('sections', 'search', 'stats'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        return view('admin.workout-sections.create');
    }

    public function store(StoreWorkoutSectionRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Generate slug if not provided / 🇫🇷 Générer le slug si non fourni
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        WorkoutSection::create($data);

        return redirect()->route('admin.workout-sections.index')
            ->with('success', 'Section créée avec succès.');
    }

    public function show(WorkoutSection $workoutSection)
    {
        $this->checkAdminAccess();
        
        $workoutSection->loadCount('categories');
        
        return view('admin.workout-sections.show', compact('workoutSection'));
    }

    public function edit(WorkoutSection $workoutSection)
    {
        $this->checkAdminAccess();
        
        return view('admin.workout-sections.edit', compact('workoutSection'));
    }

    public function update(UpdateWorkoutSectionRequest $request, WorkoutSection $workoutSection)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // 🇬🇧 Handle slug / 🇫🇷 Gérer le slug
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $workoutSection->update($data);

        return redirect()->route('admin.workout-sections.index')
            ->with('success', 'Section mise à jour avec succès.');
    }

    public function destroy(WorkoutSection $workoutSection)
    {
        $this->checkAdminAccess();
        
        // 🇬🇧 Check if section has categories / 🇫🇷 Vérifier si la section a des catégories
        if ($workoutSection->categories()->count() > 0) {
            return redirect()->route('admin.workout-sections.index')
                ->with('error', 'Impossible de supprimer une section contenant des catégories.');
        }
        
        // 🇬🇧 Soft delete / 🇫🇷 Suppression douce
        $workoutSection->delete();

        return redirect()->route('admin.workout-sections.index')
            ->with('success', 'Section supprimée avec succès.');
    }
}