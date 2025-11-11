<?php

namespace App\Http\Controllers;

use App\Models\CatalogueSection;
use App\Models\CatalogueModule;
use App\Models\CatalogueUnit;
use Illuminate\Http\Request;

/**
 * 🇬🇧 CatalogueController - Public display of catalogue
 * 🇫🇷 CatalogueController - Affichage public du catalogue
 * 
 * @file app/Http/Controllers/CatalogueController.php
 */
class CatalogueController extends Controller
{
    /**
     * 🇬🇧 Display the catalogue index with all sections
     * 🇫🇷 Afficher l'index du catalogue avec toutes les sections
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
     * 🇬🇧 Display a section with its modules
     * 🇫🇷 Afficher une section avec ses modules
     */
    public function section(CatalogueSection $section)
    {
        if (!$section->is_active) {
            abort(404);
        }

        $modules = $section->activeModules()
            ->withCount('units')
            ->get();

        // 🇬🇧 Increment views / 🇫🇷 Incrémenter les vues (optionnel)
        // $section->increment('views_count');

        return view('public.catalogue.section', compact('section', 'modules'));
    }

    /**
     * 🇬🇧 Display a module with its units
     * 🇫🇷 Afficher un module avec ses unités
     */
    public function module(CatalogueSection $section, CatalogueModule $module)
    {
        if (!$section->is_active || !$module->is_active) {
            abort(404);
        }

        // 🇬🇧 Verify module belongs to section / 🇫🇷 Vérifier que le module appartient à la section
        if ($module->catalogue_section_id !== $section->id) {
            abort(404);
        }

        $units = $module->activeUnits()
            ->with('unitable')
            ->get();

        return view('public.catalogue.module', compact('section', 'module', 'units'));
    }

    /**
     * 🇬🇧 Display a unit and redirect to its content
     * 🇫🇷 Afficher une unité et rediriger vers son contenu
     */
    public function unit(CatalogueSection $section, CatalogueModule $module, CatalogueUnit $unit)
    {
        if (!$section->is_active || !$module->is_active || !$unit->is_active) {
            abort(404);
        }

        // 🇬🇧 Verify relationships / 🇫🇷 Vérifier les relations
        if ($module->catalogue_section_id !== $section->id || $unit->catalogue_module_id !== $module->id) {
            abort(404);
        }

        $unit->load(['unitable', 'module.section']);

        // 🇬🇧 If no content linked, show unit page / 🇫🇷 Si aucun contenu lié, afficher la page unité
        if (!$unit->unitable) {
            return view('public.catalogue.unit', compact('section', 'module', 'unit'));
        }

        // 🇬🇧 Redirect to actual content / 🇫🇷 Rediriger vers le contenu réel
        $contentUrl = $unit->content_url;
        
        if ($contentUrl) {
            return redirect($contentUrl);
        }

        // 🇬🇧 Fallback: show unit page / 🇫🇷 Solution de secours : afficher la page unité
        return view('public.catalogue.unit', compact('section', 'module', 'unit'));
    }
}