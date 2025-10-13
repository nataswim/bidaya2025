<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoCategoryRequest;
use App\Http\Requests\UpdateVideoCategoryRequest;

/**
 * Controller Admin pour les catégories de vidéos
 * 
 * @file app/Http/Controllers/Admin/VideoCategoryController.php
 */
class VideoCategoryController extends Controller
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
        
        $query = VideoCategory::withCount('videos');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $categories = $query->orderBy('sort_order', 'asc')
                           ->orderBy('name', 'asc')
                           ->paginate(15);

        return view('admin.video-categories.index', compact(
            'categories', 
            'search', 
            'status'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        return view('admin.video-categories.create');
    }

    public function store(StoreVideoCategoryRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $data['is_active'] = $request->boolean('is_active', true);
        
        VideoCategory::create($data);

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(VideoCategory $videoCategory)
    {
        $this->checkAdminAccess();
        
        $videoCategory->loadCount('videos');
        
        return view('admin.video-categories.show', compact('videoCategory'));
    }

    public function edit(VideoCategory $videoCategory)
    {
        $this->checkAdminAccess();
        return view('admin.video-categories.edit', compact('videoCategory'));
    }

    public function update(UpdateVideoCategoryRequest $request, VideoCategory $videoCategory)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['name']);
        }
        
        $data['is_active'] = $request->boolean('is_active', true);
        
        $videoCategory->update($data);

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(VideoCategory $videoCategory)
    {
        $this->checkAdminAccess();
        
        if ($videoCategory->videos()->count() > 0) {
            return redirect()->route('admin.video-categories.index')
                ->with('error', 'Impossible de supprimer une catégorie contenant des vidéos.');
        }
        
        $videoCategory->delete();

        return redirect()->route('admin.video-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}