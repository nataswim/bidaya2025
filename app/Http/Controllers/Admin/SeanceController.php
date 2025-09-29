<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeanceController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé');
        }
    }

    public function index(Request $request): View
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $niveau = $request->input('niveau');
        $type = $request->input('type');
        
        $query = Seance::with(['creator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($niveau) {
            $query->where('niveau', $niveau);
        }

        if ($type) {
            $query->where('type_seance', $type);
        }

        $seances = $query->ordered()->paginate(15);

        return view('admin.training.seances.index', compact('seances', 'search', 'niveau', 'type'));
    }

    public function create(): View
    {
        $this->checkAdminAccess();
        $series = Serie::with('exercice')->active()->ordered()->get();
        return view('admin.training.seances.create', compact('series'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'duree_estimee_minutes' => 'nullable|integer|min:1|max:480',
            'type_seance' => 'required|in:force,cardio,mixte,recuperation',
            'materiel_requis' => 'nullable|string',
            'echauffement' => 'nullable|string',
            'retour_calme' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'series' => 'nullable|array',
            'series.*.serie_id' => 'required_with:series|exists:series,id',
            'series.*.ordre' => 'required_with:series|integer|min:1',
            'series.*.nombre_series' => 'required_with:series|integer|min:1|max:10',
            'series.*.notes' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $seance = Seance::create($validated);

        // Attacher les séries
        if (!empty($validated['series'])) {
            foreach ($validated['series'] as $serie) {
                $seance->series()->attach($serie['serie_id'], [
                    'ordre' => $serie['ordre'],
                    'nombre_series' => $serie['nombre_series'],
                    'notes' => $serie['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.training.seances.index')
            ->with('success', 'Séance créée avec succès.');
    }

    public function show(Seance $seance): View
    {
        $this->checkAdminAccess();
        $seance->load(['creator', 'series.exercice', 'cycles']);
        return view('admin.training.seances.show', compact('seance'));
    }

    public function edit(Seance $seance): View
    {
        $this->checkAdminAccess();
        $seance->load(['series']);
        $series = Serie::with('exercice')->active()->ordered()->get();
        return view('admin.training.seances.edit', compact('seance', 'series'));
    }

    public function update(Request $request, Seance $seance): RedirectResponse
    {
        $this->checkAdminAccess();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|in:debutant,intermediaire,avance,special',
            'duree_estimee_minutes' => 'nullable|integer|min:1|max:480',
            'type_seance' => 'required|in:force,cardio,mixte,recuperation',
            'materiel_requis' => 'nullable|string',
            'echauffement' => 'nullable|string',
            'retour_calme' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
            'series' => 'nullable|array',
            'series.*.serie_id' => 'required_with:series|exists:series,id',
            'series.*.ordre' => 'required_with:series|integer|min:1',
            'series.*.nombre_series' => 'required_with:series|integer|min:1|max:10',
            'series.*.notes' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['ordre'] = $validated['ordre'] ?? $seance->ordre;

        $seance->update($validated);

        // Resynchroniser les séries
        $seance->series()->detach();
        if (!empty($validated['series'])) {
            foreach ($validated['series'] as $serie) {
                $seance->series()->attach($serie['serie_id'], [
                    'ordre' => $serie['ordre'],
                    'nombre_series' => $serie['nombre_series'],
                    'notes' => $serie['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.training.seances.index')
            ->with('success', 'Séance mise à jour avec succès.');
    }

    public function destroy(Seance $seance): RedirectResponse
    {
        $this->checkAdminAccess();
        
        // Vérifier si la séance est utilisée dans des cycles
        if ($seance->cycles()->count() > 0) {
            return redirect()->route('admin.training.seances.index')
                ->with('error', 'Impossible de supprimer une séance utilisée dans des cycles.');
        }

        $seance->series()->detach();
        $seance->delete();

        return redirect()->route('admin.training.seances.index')
            ->with('success', 'Séance supprimée avec succès.');
    }
}