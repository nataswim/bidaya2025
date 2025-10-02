<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notebook;
use App\Models\NotebookItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class NotebookController extends Controller
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
     * Liste des carnets
     */
    public function index()
    {
        $this->checkPremiumAccess();
        
        $notebooks = Notebook::forUser(auth()->id())
            ->withCount('items')
            ->orderByDesc('is_favorite')
            ->orderByDesc('updated_at')
            ->get();
        
        return view('user.notebooks.index', compact('notebooks'));
    }

    /**
     * Afficher un carnet
     */
    public function show(Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        // Vérifier que le carnet appartient à l'utilisateur
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $notebook->load(['items.notebookable']);
        
        return view('user.notebooks.show', compact('notebook'));
    }

    /**
     * Créer un carnet
     */
    public function store(Request $request)
    {
        $this->checkPremiumAccess();
        
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'content_type' => 'required|in:posts,fiches,exercices,workouts,plans,downloadables',
            'color' => 'nullable|string|max:7',
        ]);
        
        $notebook = Notebook::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content_type' => $validated['content_type'],
            'color' => $validated['color'] ?? '#007bff',
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'notebook' => $notebook,
                'message' => 'Carnet créé avec succès'
            ]);
        }
        
        return redirect()->route('user.notebooks.show', $notebook)
            ->with('success', 'Carnet créé avec succès');
    }

    /**
     * Mettre à jour un carnet
     */
    public function update(Request $request, Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'is_favorite' => 'boolean',
        ]);
        
        $notebook->update($validated);
        
        return redirect()->route('user.notebooks.show', $notebook)
            ->with('success', 'Carnet mis à jour');
    }

    /**
     * Supprimer un carnet
     */
    public function destroy(Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $notebook->delete();
        
        return redirect()->route('user.notebooks.index')
            ->with('success', 'Carnet supprimé');
    }

    /**
     * Ajouter un contenu au carnet
     */
    public function addItem(Request $request)
    {
        $this->checkPremiumAccess();
        
        $validated = $request->validate([
            'notebook_id' => 'required|exists:notebooks,id',
            'content_type' => 'required|string',
            'content_id' => 'required|integer',
        ]);
        
        $notebook = Notebook::findOrFail($validated['notebook_id']);
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Mapper le type de contenu vers le modèle
        $modelClass = match($validated['content_type']) {
            'posts' => \App\Models\Post::class,
            'fiches' => \App\Models\Fiche::class,
            'exercices' => \App\Models\Exercice::class,
            'workouts' => \App\Models\Workout::class,
            'plans' => \App\Models\Plan::class,
            'downloadables' => \App\Models\Downloadable::class,
            default => null
        };
        
        if (!$modelClass) {
            return response()->json(['error' => 'Type de contenu invalide'], 400);
        }
        
        // Vérifier que le contenu existe
        $content = $modelClass::find($validated['content_id']);
        if (!$content) {
            return response()->json(['error' => 'Contenu introuvable'], 404);
        }
        
        // Vérifier si déjà dans le carnet
        $exists = NotebookItem::where('notebook_id', $notebook->id)
            ->where('notebookable_type', $modelClass)
            ->where('notebookable_id', $validated['content_id'])
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ce contenu est déjà dans ce carnet'
            ], 409);
        }
        
        // Obtenir le dernier ordre
        $maxOrder = NotebookItem::where('notebook_id', $notebook->id)->max('order') ?? -1;
        
        // Créer l'item
        $item = NotebookItem::create([
            'notebook_id' => $notebook->id,
            'notebookable_type' => $modelClass,
            'notebookable_id' => $validated['content_id'],
            'order' => $maxOrder + 1,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Contenu ajouté au carnet',
            'item' => $item
        ]);
    }

    /**
     * Retirer un contenu du carnet
     */
    public function removeItem(NotebookItem $item)
    {
        $this->checkPremiumAccess();
        
        if ($item->notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $item->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Contenu retiré du carnet'
        ]);
    }

    /**
     * Mettre à jour la note personnelle
     */
    public function updateNote(Request $request, NotebookItem $item)
    {
        $this->checkPremiumAccess();
        
        if ($item->notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'personal_note' => 'nullable|string|max:1000',
        ]);
        
        $item->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Note mise à jour'
        ]);
    }

    /**
     * Réorganiser les contenus
     */
    public function reorder(Request $request, Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:notebook_items,id',
            'items.*.order' => 'required|integer',
        ]);
        
        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $itemData) {
                NotebookItem::where('id', $itemData['id'])
                    ->update(['order' => $itemData['order']]);
            }
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Ordre mis à jour'
        ]);
    }

    /**
     * Exporter en PDF
     */
    public function exportPdf(Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $notebook->load(['items.notebookable']);
        
        $pdf = Pdf::loadView('user.notebooks.pdf', compact('notebook'));
        
        return $pdf->download('carnet-' . \Str::slug($notebook->title) . '.pdf');
    }

    /**
     * Toggle favori
     */
    public function toggleFavorite(Notebook $notebook)
    {
        $this->checkPremiumAccess();
        
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        
        $notebook->update(['is_favorite' => !$notebook->is_favorite]);
        
        return response()->json([
            'success' => true,
            'is_favorite' => $notebook->is_favorite
        ]);
    }

/**
 * API pour obtenir les carnets par type (pour le modal)
 */
public function getByType(Request $request)
{
    $this->checkPremiumAccess();
    
    $contentType = $request->query('content_type');
    
    $notebooks = Notebook::forUser(auth()->id())
        ->byContentType($contentType)
        ->withCount('items')
        ->orderByDesc('is_favorite')
        ->orderByDesc('updated_at')
        ->get()
        ->map(function($notebook) {
            return [
                'id' => $notebook->id,
                'title' => $notebook->title,
                'icon' => $notebook->content_type_icon,
                'color' => $notebook->color,
                'items_count' => $notebook->items_count,
            ];
        });
    
    return response()->json($notebooks);
}
}