<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $tag = $request->input('tag');
        
        // Tous les posts publiés sont listés (métadonnées visibles)
        $query = Post::with(['category', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Recherche dans titre et intro (toujours visibles)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('intro', 'like', "%{$search}%")
                  ->orWhere('meta_keywords', 'like', "%{$search}%");
            });
        }

        // Filtrage par catégorie
        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Filtrage par tag
        if ($tag) {
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('slug', $tag);
            });
        }

        $posts = $query->orderBy('published_at', 'desc')
                      ->orderBy('order', 'asc')
                      ->paginate(12);

        // Récupérer les catégories et tags actifs pour les filtres
        $categories = Category::where('status', 'active')
                             ->withCount('posts')
                             ->orderBy('order', 'asc')
                             ->orderBy('name', 'asc')
                             ->get();

        $tags = Tag::where('status', 'active')
                   ->withCount('posts')
                   ->orderBy('name', 'asc')
                   ->limit(20)
                   ->get();

        return view('public.index', compact('posts', 'categories', 'tags', 'search', 'category', 'tag'));
    }

    public function show(Post $post)
    {
        // Vérifier si le post est publié (métadonnées visibles)
        if (!$post->isMetadataVisible()) {
            abort(404, 'Article non trouvé.');
        }

        // Incrémenter les vues pour tous les visiteurs (même si contenu restreint)
        $post->increment('hits');

        // Charger les relations nécessaires
        $post->load(['category', 'tags', 'creator']);

        // Déterminer si le contenu complet est visible
        $contentVisible = $post->isContentVisibleTo(auth()->user());

        // Articles similaires (même catégorie, métadonnées visibles)
        $relatedPosts = collect();
        if ($post->category_id) {
            $relatedPosts = Post::where('status', 'published')
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->limit(4)
                ->get();
        }

        // Articles populaires si pas assez d'articles similaires
        if ($relatedPosts->count() < 3) {
            $popularPosts = Post::where('status', 'published')
                ->where('id', '!=', $post->id)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('hits', 'desc')
                ->limit(4 - $relatedPosts->count())
                ->get();
            
            $relatedPosts = $relatedPosts->merge($popularPosts);
        }

        return view('public.show', compact('post', 'relatedPosts', 'contentVisible'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function home()
    {
        // Page d'accueil avec articles mis en avant
        $featuredPosts = Post::where('status', 'published')
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Articles récents
        $recentPosts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        // Catégories populaires
        $popularCategories = Category::where('status', 'active')
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published')
                      ->whereNotNull('published_at')
                      ->where('published_at', '<=', now());
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->limit(6)
            ->get();

        return view('public.home', compact('featuredPosts', 'recentPosts', 'popularCategories'));
    }

    /**
     * Recherche avancée
     */
    public function search(Request $request)
    {
        $search = $request->input('q');
        $category_id = $request->input('category_id');
        $tag_id = $request->input('tag_id');
        
        if (empty($search) && empty($category_id) && empty($tag_id)) {
            return redirect()->route('public.index');
        }

        $query = Post::with(['category', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('intro', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('meta_keywords', 'like', "%{$search}%");
            });
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($tag_id) {
            $query->whereHas('tags', function($q) use ($tag_id) {
                $q->where('tags.id', $tag_id);
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $tags = Tag::where('status', 'active')->orderBy('name')->get();

        return view('public.search', compact('posts', 'categories', 'tags', 'search', 'category_id', 'tag_id'));
    }

    /**
     * Flux RSS
     */
    public function rss()
    {
        $posts = Post::where('status', 'published')
            ->where('visibility', 'public') // Seulement les posts publics dans le RSS
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()->view('public.rss', compact('posts'))
            ->header('Content-Type', 'application/rss+xml');
    }

    /**
     * Sitemap XML
     */
    public function sitemap()
    {
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::where('status', 'active')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('public.sitemap', compact('posts', 'categories'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Affichage par catégorie
     */
    public function category(Category $category)
    {
        if ($category->status !== 'active') {
            abort(404, 'Catégorie non trouvée.');
        }

        $posts = Post::where('status', 'published')
            ->where('category_id', $category->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('public.category', compact('category', 'posts'));
    }

    /**
     * Affichage par tag
     */
    public function tag(Tag $tag)
    {
        if ($tag->status !== 'active') {
            abort(404, 'Tag non trouvé.');
        }

        $posts = $tag->posts()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('public.tag', compact('tag', 'posts'));
    }

    /**
     * API pour la recherche auto-complete
     */
    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $posts = Post::where('status', 'published')
            ->where('name', 'like', "%{$query}%")
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->select('name', 'slug')
            ->limit(10)
            ->get();

        return response()->json($posts);
    }
}