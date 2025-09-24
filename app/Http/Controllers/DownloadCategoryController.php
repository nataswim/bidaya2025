<?php

namespace App\Http\Controllers;

use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDownloadCategoryRequest;
use App\Http\Requests\UpdateDownloadCategoryRequest;

class DownloadCategoryController extends Controller
{
    private function checkAdminAccess()
{
    $user = auth()->user();
    
    if (!$user || !$user->role) {
        abort(403, 'Accès non autorisé - Aucun rôle assigné');
    }
    
    if (!$user->hasRole('admin') && !$user->hasRole('editor')) {
        abort(403, 'Accès non autorisé');
    }
}

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = DownloadCategory::with(['creator', 'updater']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $categories = $query->orderBy('order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(15);

        return view('admin.download-categories.index', compact(
            'categories', 
            'search', 
            'status'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        return view('admin.download-categories.create');
    }

    public function store(StoreDownloadCategoryRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $category = DownloadCategory::create($data);

        return redirect()->route('admin.download-categories.index')
            ->with('success', 'CatÃ©gorie crÃ©Ã©e avec succÃ¨s.');
    }

    public function show(DownloadCategory $downloadCategory)
    {
        $this->checkAdminAccess();
        
        $downloadCategory->load(['creator', 'updater', 'downloadables' => function($query) {
            $query->orderBy('order', 'asc')->orderBy('title', 'asc');
        }]);
        
        return view('admin.download-categories.show', compact('downloadCategory'));
    }

    public function edit(DownloadCategory $downloadCategory)
    {
        $this->checkAdminAccess();
        return view('admin.download-categories.edit', compact('downloadCategory'));
    }

    public function update(UpdateDownloadCategoryRequest $request, DownloadCategory $downloadCategory)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $downloadCategory->update($data);

        return redirect()->route('admin.download-categories.index')
            ->with('success', 'CatÃ©gorie mise Ã jour avec succÃ¨s.');
    }

    public function destroy(DownloadCategory $downloadCategory)
    {
        $this->checkAdminAccess();
        
        // VÃ©rifier s'il y a des tÃ©lÃ©chargements associÃ©s
        if ($downloadCategory->downloadables()->count() > 0) {
            return redirect()->route('admin.download-categories.index')
                ->with('error', 'Impossible de supprimer une catÃ©gorie contenant des tÃ©lÃ©chargements.');
        }
        
        $downloadCategory->delete();

        return redirect()->route('admin.download-categories.index')
            ->with('success', 'CatÃ©gorie supprimÃ©e avec succÃ¨s.');
    }

    /**
     * Statistiques des catÃ©gories
     */
    public function stats()
    {
        $this->checkAdminAccess();
        
        $stats = [
            'total_categories' => DownloadCategory::count(),
            'active_categories' => DownloadCategory::where('status', 'active')->count(),
            'inactive_categories' => DownloadCategory::where('status', 'inactive')->count(),
            'categories_with_downloads' => DownloadCategory::has('downloadables')->count(),
            'empty_categories' => DownloadCategory::doesntHave('downloadables')->count(),
            'total_downloads' => \App\Models\Downloadable::count(),
            'by_category' => DownloadCategory::withCount('downloadables')
                ->orderBy('downloadables_count', 'desc')
                ->get(),
        ];

        return view('admin.download-categories.stats', compact('stats'));
    }
}