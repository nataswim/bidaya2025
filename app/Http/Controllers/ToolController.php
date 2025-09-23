<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function bmiCalculator()
    {
        return view('public.tools.bmi-calculator');
    }
    public function bodyFatCalculator()
    {
        return view('public.tools.masse-grasse');
    }
     public function calorieCalculator()
    {
        return view('public.tools.calculateur-calories');
    }
    public function swimmingChronometer()
    {
        return view('public.tools.chronometre-natation');
    }
    public function chronometerPro()
    {
        return view('public.tools.chronometre-pro');
    }
    public function criticalSwimSpeed()
    {
        return view('public.tools.calculateur-vnc');
    }
    public function fitnessCalculator()
    {
        return view('public.tools.calculateur-fitness');
    }
    public function heartCoherence()
    {
        return view('public.tools.coherence-cardiaque');
    }
    public function hydrationCalculator()
    {
        return view('public.tools.calculateur-hydratation');
    }
    public function interactiveMap()
    {
        return view('public.tools.carte-interactive');
    }
    public function kcalMacroConverter()
    {
        return view('public.tools.convertisseur-kcal-macros');
    }
    public function onermCalculator()
    {
        return view('public.tools.onermCalculator');
    }
    public function runningPlanner()
    {
        return view('public.tools.running-planner');
    }
    public function swimmingPredictor()
    {
        return view('public.tools.predicteur-natation');
    }
    public function swimmingPlanner()
    {
        return view('public.tools.planificateur-natation');
    }
    public function heartRateZones()
    {
        return view('public.tools.zones-cardiaques');
    }
    public function tdeeCalculator()
    {
        return view('public.tools.calculateur-tdee');
    }
    public function triathlonPlanner()
    {
        return view('public.tools.planificateur-triathlon');
    }
    public function index()
{
    return view('public.tools.index');
}
public function swimmingEfficiency()
{
    return view('public.tools.efficacite-technique-natation');
}
public function healthBodyComposition()
{
    return view('public.tools.categories.health-body-composition');
}

public function nutritionEnergy()
{
    return view('public.tools.categories.nutrition-energy');
}

public function cardiacPerformance()
{
    return view('public.tools.categories.cardiac-performance');
}

public function aquaticSports()
{
    return view('public.tools.categories.aquatic-sports');
}

public function runningEndurance()
{
    return view('public.tools.categories.running-endurance');
}

public function strengthTraining()
{
    return view('public.tools.categories.strength-training');
}

public function practicalTools()
{
    return view('public.tools.categories.practical-tools');
}

public function developmentTools()
{
    return view('public.tools.categories.development-tools');
}

}