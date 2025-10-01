<?php

namespace App\Http\Controllers;

use App\Models\WorkoutSection;
use App\Models\WorkoutCategory;
use App\Models\Workout;
use Illuminate\Http\Request;

/**
 * 🇬🇧 PublicWorkoutController - Public display of workouts
 * 🇫🇷 PublicWorkoutController - Affichage public des workouts
 * 
 * @file app/Http/Controllers/PublicWorkoutController.php
 */
class PublicWorkoutController extends Controller
{
    /**
     * 🇬🇧 Display all workout sections
     * 🇫🇷 Afficher toutes les sections de workout
     */
    public function index()
    {
        $sections = WorkoutSection::active()
                                  ->ordered()
                                  ->with(['categories' => function($query) {
                                      $query->active()
                                            ->ordered()
                                            ->withCount('workouts');
                                  }])
                                  ->get();

        return view('public.workouts.index', compact('sections'));
    }

    /**
     * 🇬🇧 Display a specific section with its categories
     * 🇫🇷 Afficher une section spécifique avec ses catégories
     */
    public function section(WorkoutSection $section)
    {
        $categories = $section->categories()
                             ->active()
                             ->ordered()
                             ->withCount('workouts')
                             ->get();

        return view('public.workouts.section', compact('section', 'categories'));
    }

    /**
     * 🇬🇧 Display workouts of a specific category
     * 🇫🇷 Afficher les workouts d'une catégorie spécifique
     */
    public function category(WorkoutSection $section, WorkoutCategory $category)
    {
        // 🇬🇧 Verify category belongs to section / 🇫🇷 Vérifier que la catégorie appartient à la section
        if ($category->workout_section_id !== $section->id) {
            abort(404);
        }

        $workouts = $category->workouts()
                            ->orderBy('workout_workout_category.order_number', 'asc')
                            ->get();

        return view('public.workouts.category', compact('section', 'category', 'workouts'));
    }

    /**
     * 🇬🇧 Display a specific workout
     * 🇫🇷 Afficher un workout spécifique
     */
    public function show(WorkoutSection $section, WorkoutCategory $category, Workout $workout)
    {
        // 🇬🇧 Verify workout belongs to category / 🇫🇷 Vérifier que le workout appartient à la catégorie
        if (!$workout->categories->contains($category->id)) {
            abort(404);
        }

        // 🇬🇧 Get order number for this category / 🇫🇷 Obtenir le numéro d'ordre pour cette catégorie
        $orderNumber = $workout->categories()
                              ->where('workout_categories.id', $category->id)
                              ->first()
                              ->pivot
                              ->order_number ?? null;

        // 🇬🇧 Get related workouts in same category / 🇫🇷 Obtenir les workouts associés de la même catégorie
        $relatedWorkouts = $category->workouts()
                                   ->where('workouts.id', '!=', $workout->id)
                                   ->orderBy('workout_workout_category.order_number', 'asc')
                                   ->limit(3)
                                   ->get();

        $workout->load('categories.section');

        return view('public.workouts.show', compact(
            'section',
            'category',
            'workout',
            'orderNumber',
            'relatedWorkouts'
        ));
    }
}