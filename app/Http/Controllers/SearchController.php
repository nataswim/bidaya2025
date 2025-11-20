<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fiche;
use App\Models\Post;
use App\Models\Video;

class SearchController extends Controller
{
    /**
     * Afficher les résultats de recherche
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        // Si pas de recherche, retourner la page vide
        if (empty($query)) {
            return view('public.search', [
                'query' => '',
                'results' => [],
                'totalResults' => 0
            ]);
        }

        // Limiter à 10 résultats par catégorie
        $limit = 10;

        // Recherche dans chaque modèle
        $results = [
            'posts' => $this->searchPosts($query, $limit),
            'fiches' => $this->searchFiches($query, $limit),
            'videos' => $this->searchVideos($query, $limit),
        ];

        // Calculer le total de résultats
        $totalResults = collect($results)->sum(fn($items) => $items->count());

        return view('public.search', [
            'query' => $query,
            'results' => $results,
            'totalResults' => $totalResults
        ]);
    }

    /**
     * Rechercher dans les Articles
     */
    private function searchPosts($query, $limit)
    {
        return Post::visibleTo(auth()->user())
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('intro', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Rechercher dans les Fiches
     */
    private function searchFiches($query, $limit)
    {
        return Fiche::visibleTo(auth()->user())
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('long_description', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Rechercher dans les Vidéos
     */
    private function searchVideos($query, $limit)
    {
        return Video::visibleTo(auth()->user())
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}