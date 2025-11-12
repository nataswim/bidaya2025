<?php

namespace App\Http\Controllers;

use App\Models\CatalogueSection;
use App\Models\CatalogueModule;
use App\Models\CatalogueUnit;
use Illuminate\Http\Request;

/**
 * CatalogueController - Affichage public du catalogue
 */
class CatalogueController extends Controller
{
    /**
     * Afficher l'index du catalogue avec toutes les sections
     */
    public function index()
    {
        $sections = CatalogueSection::active()
            ->ordered()
            ->withCount('modules')
            ->get();

        return view('public.catalogue.index', compact('sections'));
    }

    /**
     * Afficher une section avec ses modules
     */
    public function section(CatalogueSection $section)
    {
        if (!$section->is_active) {
            abort(404);
        }

        $modules = $section->activeModules()
            ->withCount('units')
            ->get();

        return view('public.catalogue.section', compact('section', 'modules'));
    }

    /**
     * Afficher un module avec ses unités
     */
    public function module(CatalogueSection $section, CatalogueModule $module)
    {
        if (!$section->is_active || !$module->is_active) {
            abort(404);
        }

        // Vérifier que le module appartient à la section
        if ($module->catalogue_section_id !== $section->id) {
            abort(404);
        }

        // Charger les unités avec le compte des contenus
        $units = $module->activeUnits()
            ->withCount(['contents' => function($query) {
                $query->where('is_active', true);
            }])
            ->with(['contents' => function($query) {
                $query->where('is_active', true)
                      ->ordered();
            }])
            ->get();

        return view('public.catalogue.module', compact('section', 'module', 'units'));
    }

    /**
     * Afficher une unité avec ses contenus multiples
     */
    public function unit(CatalogueSection $section, CatalogueModule $module, CatalogueUnit $unit)
    {
        if (!$section->is_active || !$module->is_active || !$unit->is_active) {
            abort(404);
        }

        // Vérifier les relations
        if ($module->catalogue_section_id !== $section->id || $unit->catalogue_module_id !== $module->id) {
            abort(404);
        }

        // Charger l'unité avec ses contenus actifs et ordonnés
        $unit->load(['module.section', 'contents' => function($query) {
            $query->where('is_active', true)
                  ->ordered()
                  ->with('contentable');
        }]);

        return view('public.catalogue.unit', compact('section', 'module', 'unit'));
    }
}