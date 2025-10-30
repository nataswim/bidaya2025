<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Services\VideoService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;

/**
 * Controller Admin pour les vidéos
 * 
 * @file app/Http/Controllers/Admin/VideoController.php
 */
class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

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
        $type = $request->input('type');
        $visibility = $request->input('visibility');
        $categoryId = $request->input('category');
        $featured = $request->input('featured');
        
        $query = Video::with(['categories', 'creator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($visibility) {
            $query->where('visibility', $visibility);
        }

        if ($categoryId) {
            $query->whereHas('categories', function($q) use ($categoryId) {
                $q->where('video_categories.id', $categoryId);
            });
        }

        if ($featured) {
            $query->where('is_featured', true);
        }

        $videos = $query->orderBy('created_at', 'desc')
                       ->orderBy('sort_order', 'asc')
                       ->paginate(15);

        $categories = VideoCategory::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total' => Video::count(),
            'published' => Video::where('is_published', true)->count(),
            'draft' => Video::where('is_published', false)->count(),
            'upload' => Video::where('type', 'upload')->count(),
            'external' => Video::whereIn('type', ['url', 'youtube', 'vimeo', 'dailymotion'])->count(),
            'featured' => Video::where('is_featured', true)->count(),
        ];

        return view('admin.videos.index', compact(
            'videos',
            'categories',
            'stats',
            'search',
            'type',
            'visibility',
            'categoryId',
            'featured'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = VideoCategory::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.videos.create', compact('categories'));
    }





    
    public function store(StoreVideoRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
    // Gestion de l'upload classique
    if ($request->hasFile('file')) {
        $uploadData = $this->videoService->uploadVideo($request->file('file'));
        $data = array_merge($data, $uploadData);
    }
    // NOUVEAU : Gestion depuis la bibliothèque
    elseif ($request->filled('library_file_path')) {
        $data['type'] = 'upload';
        $data['file_path'] = $request->input('library_file_path');
        $data['file_size'] = $request->input('library_file_size');
        $data['mime_type'] = $request->input('library_mime_type');
    }
        
        // Gestion des URLs externes et métadonnées
        if (in_array($data['type'], ['youtube', 'vimeo', 'dailymotion']) && !empty($data['external_url'])) {
            $metadata = null;
            
            switch ($data['type']) {
                case 'youtube':
                    $metadata = $this->videoService->getYoutubeMetadata($data['external_url']);
                    break;
                case 'vimeo':
                    $metadata = $this->videoService->getVimeoMetadata($data['external_url']);
                    break;
                case 'dailymotion':
                    $metadata = $this->videoService->getDailymotionMetadata($data['external_url']);
                    break;
            }
            
            if ($metadata) {
                $data['external_id'] = $metadata['external_id'] ?? null;
                $data['thumbnail'] = $data['thumbnail'] ?? $metadata['thumbnail'] ?? null;
                $data['width'] = $data['width'] ?? $metadata['width'] ?? null;
                $data['height'] = $data['height'] ?? $metadata['height'] ?? null;
                $data['duration'] = $data['duration'] ?? $metadata['duration'] ?? null;
            }
        }
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        
        $video = Video::create($data);
        
        // Synchroniser les catégories
        if ($request->has('categories')) {
            $video->categories()->sync($request->input('categories'));
        }

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.videos.edit', $video)
                ->with('success', 'Vidéo créée avec succès. Vous pouvez continuer à l\'éditer.');
        }

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo créée avec succès.');
    }










    public function show(Video $video)
    {
        $this->checkAdminAccess();
        
        $video->load(['categories', 'creator', 'updater']);
        
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $this->checkAdminAccess();
        
        $categories = VideoCategory::where('is_active', true)->orderBy('name')->get();
        $video->load('categories');
        
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // Gestion de l'upload d'un nouveau fichier
    if ($request->hasFile('file')) {
        // Supprimer l'ancien fichier
        if ($video->file_path) {
            $this->videoService->deleteVideo($video->file_path);
        }
        
        $uploadData = $this->videoService->uploadVideo($request->file('file'));
        $data = array_merge($data, $uploadData);
    }
    // NOUVEAU : Gestion depuis la bibliothèque
    elseif ($request->filled('library_file_path')) {
        // Supprimer l'ancien fichier si changement de source
        if ($video->file_path && $video->file_path !== $request->input('library_file_path')) {
            $this->videoService->deleteVideo($video->file_path);
        }
        
        $data['type'] = 'upload';
        $data['file_path'] = $request->input('library_file_path');
        $data['file_size'] = $request->input('library_file_size');
        $data['mime_type'] = $request->input('library_mime_type');
    }
        
        // Mise à jour des métadonnées externes si URL modifiée
        if (in_array($data['type'], ['youtube', 'vimeo', 'dailymotion']) && 
            !empty($data['external_url']) && 
            $data['external_url'] !== $video->external_url) {
            
            $metadata = null;
            
            switch ($data['type']) {
                case 'youtube':
                    $metadata = $this->videoService->getYoutubeMetadata($data['external_url']);
                    break;
                case 'vimeo':
                    $metadata = $this->videoService->getVimeoMetadata($data['external_url']);
                    break;
                case 'dailymotion':
                    $metadata = $this->videoService->getDailymotionMetadata($data['external_url']);
                    break;
            }
            
            if ($metadata) {
                $data['external_id'] = $metadata['external_id'] ?? $video->external_id;
                if (empty($data['thumbnail'])) {
                    $data['thumbnail'] = $metadata['thumbnail'] ?? $video->thumbnail;
                }
                if (empty($data['width'])) {
                    $data['width'] = $metadata['width'] ?? $video->width;
                }
                if (empty($data['height'])) {
                    $data['height'] = $metadata['height'] ?? $video->height;
                }
                if (empty($data['duration'])) {
                    $data['duration'] = $metadata['duration'] ?? $video->duration;
                }
            }
        }
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        if (!empty($data['is_published'])) {
            if (empty($data['published_at']) && !$video->is_published) {
                $data['published_at'] = now();
            }
        }
        
        $video->update($data);
        
        // Synchroniser les catégories
        if ($request->has('categories')) {
            $video->categories()->sync($request->input('categories'));
        }

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.videos.edit', $video)
                ->with('success', 'Vidéo mise à jour avec succès.');
        }

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo mise à jour avec succès.');
    }

    public function destroy(Video $video)
    {
        $this->checkAdminAccess();
        
        // Supprimer le fichier si upload
        if ($video->type === 'upload' && $video->file_path) {
            $this->videoService->deleteVideo($video->file_path);
        }
        
        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès.');
    }

    /**
     * API pour récupérer les métadonnées d'une vidéo externe
     */
    public function fetchMetadata(Request $request)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'url' => 'required|url',
            'type' => 'required|in:youtube,vimeo,dailymotion'
        ]);

        $metadata = null;
        
        switch ($request->type) {
            case 'youtube':
                $metadata = $this->videoService->getYoutubeMetadata($request->url);
                break;
            case 'vimeo':
                $metadata = $this->videoService->getVimeoMetadata($request->url);
                break;
            case 'dailymotion':
                $metadata = $this->videoService->getDailymotionMetadata($request->url);
                break;
        }

        if ($metadata) {
            return response()->json([
                'success' => true,
                'data' => $metadata
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Impossible de récupérer les métadonnées'
        ], 400);
    }
}