<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;

/**
 * Controller Public pour les vidéos
 * 
 * @file app/Http/Controllers/PublicVideoController.php
 */
class PublicVideoController extends Controller
{
    /**
     * Liste de toutes les vidéos
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');
        
        $query = Video::with(['categories'])
            ->visibleTo(auth()->user())
            ->published();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('categories', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $videos = $query->orderBy('sort_order', 'asc')
                       ->orderBy('published_at', 'desc')
                       ->paginate(12);

        $categories = VideoCategory::active()
            ->withCount(['publishedVideos'])
            ->having('published_videos_count', '>', 0)
            ->ordered()
            ->get();

        $featuredVideos = Video::with(['categories'])
            ->visibleTo(auth()->user())
            ->published()
            ->featured()
            ->limit(6)
            ->get();

        return view('public.videos.index', compact(
            'videos',
            'categories',
            'featuredVideos',
            'search',
            'categorySlug'
        ));
    }

    /**
     * Vidéos d'une catégorie
     */
    public function category(VideoCategory $category)
    {
        if (!$category->is_active) {
            abort(404, 'Catégorie non trouvée.');
        }

        $videos = $category->videos()
            ->with(['categories'])
            ->visibleTo(auth()->user())
            ->published()
            ->orderBy('sort_order', 'asc')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('public.videos.category', compact('category', 'videos'));
    }

    /**
     * Afficher une vidéo
     */
    public function show(Video $video)
    {
        if (!$video->is_published) {
            abort(404, 'Vidéo non trouvée.');
        }

        // Incrémenter les vues
        $video->incrementViews();

        $video->load(['categories', 'creator']);

        $contentVisible = $video->canViewContent(auth()->user());

        // Vidéos similaires
        $relatedVideos = collect();
        if ($video->categories->count() > 0) {
            $categoryIds = $video->categories->pluck('id');
            
            $relatedVideos = Video::whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('video_categories.id', $categoryIds);
                })
                ->where('id', '!=', $video->id)
                ->visibleTo(auth()->user())
                ->published()
                ->orderBy('published_at', 'desc')
                ->limit(4)
                ->get();
        }

        return view('public.videos.show', compact(
            'video',
            'relatedVideos',
            'contentVisible'
        ));
    }
}