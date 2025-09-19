<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        
        $query = Post::with(['category', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('intro', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = Category::where('status', 'active')->get();

        return view('public.index', compact('posts', 'categories', 'search', 'category'));
    }

    public function show(Post $post)
    {
        // Vérifier que le post est publié
        if ($post->status !== 'published') {
            abort(404, 'Article non trouvé');
        }

        // Incrémenter les vues
        $post->increment('hits');

        $post->load(['category', 'tags', 'creator']);
        
        // Articles similaires
        $relatedPosts = Post::where('status', 'published')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('public.show', compact('post', 'relatedPosts'));
    }
}