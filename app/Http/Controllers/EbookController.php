<?php

namespace App\Http\Controllers;

use App\Models\DownloadCategory;
use App\Models\Downloadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    /**
     * Liste des catÃ©gories d'eBooks
     */
    public function index()
    {
        $categories = DownloadCategory::active()
            ->withCount(['downloadables' => function($query) {
                $query->active()->forPermission(auth()->user());
            }])
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $featuredDownloads = Downloadable::active()
            ->featured()
            ->forPermission(auth()->user())
            ->with('category')
            ->orderBy('download_count', 'desc')
            ->limit(6)
            ->get();

        $recentDownloads = Downloadable::active()
            ->forPermission(auth()->user())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('public.ebook.index', compact('categories', 'featuredDownloads', 'recentDownloads'));
    }

    /**
     * Affichage d'une catÃ©gorie
     */
    public function category($categorySlug, Request $request)
    {
        $category = DownloadCategory::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $query = Downloadable::where('download_category_id', $category->id)
            ->active()
            ->forPermission(auth()->user());

        // Filtres
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('format')) {
            $query->where('format', $request->input('format'));
        }

        // Tri
        switch ($request->input('sort', 'title')) {
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            case 'recent':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('order', 'asc')->orderBy('title', 'asc');
                break;
        }

        $downloadables = $query->paginate(12);

        $stats = [
            'total' => $downloadables->total(),
            'formats' => Downloadable::where('download_category_id', $category->id)
                ->active()
                ->forPermission(auth()->user())
                ->selectRaw('format, count(*) as count')
                ->groupBy('format')
                ->get()
                ->pluck('count', 'format')
        ];

        return view('public.ebook.category', compact('category', 'downloadables', 'stats'));
    }

    /**
     * DÃ©tail d'un tÃ©lÃ©chargement
     */
    public function show($categorySlug, $downloadableSlug)
    {
        $category = DownloadCategory::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $downloadable = Downloadable::where('slug', $downloadableSlug)
            ->where('download_category_id', $category->id)
            ->where('status', 'active')
            ->with(['category', 'creator'])
            ->firstOrFail();

        // Suggestions d'autres tÃ©lÃ©chargements de la même catÃ©gorie
        $relatedDownloads = Downloadable::where('download_category_id', $category->id)
            ->where('id', '!=', $downloadable->id)
            ->active()
            ->forPermission(auth()->user())
            ->orderBy('download_count', 'desc')
            ->limit(4)
            ->get();

        return view('public.ebook.show', compact('downloadable', 'category', 'relatedDownloads'));
    }

    /**
     * TÃ©lÃ©chargement d'un fichier
     */
    public function download($categorySlug, $downloadableSlug, Request $request)
    {
        $category = DownloadCategory::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();

        $downloadable = Downloadable::where('slug', $downloadableSlug)
            ->where('download_category_id', $category->id)
            ->where('status', 'active')
            ->firstOrFail();

        // VÃ©rifier les permissions
        $currentUser = auth()->user(); // RÃ©cupÃ©rer une seule fois
        
        if (!$downloadable->canBeDownloadedBy($currentUser)) {
            $message = $downloadable->getAccessMessage($currentUser);
            
            if (!$currentUser && $downloadable->user_permission === 'user') {
                return redirect()->route('login')
                    ->with('info', 'Connectez-vous pour tÃ©lÃ©charger ce fichier.');
            }
            
            return redirect()->back()
                ->with('error', $message);
        }

        // VÃ©rifier que le fichier existe
        if (!$downloadable->file_path || !Storage::disk('local')->exists($downloadable->file_path)) {
            return redirect()->back()
                ->with('error', 'Fichier non trouvÃ©.');
        }

        // IncrÃ©menter le compteur et logger
        $downloadable->incrementDownloadCount($currentUser, $request);

        // TÃ©lÃ©chargement
        $filePath = Storage::disk('local')->path($downloadable->file_path);
        $fileName = $downloadable->title . '.' . $downloadable->format;

        return response()->download($filePath, $fileName);
    }

    /**
     * Recherche dans les tÃ©lÃ©chargements
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $categoryId = $request->input('category');
        $format = $request->input('format');
        
        $downloadablesQuery = Downloadable::active()
            ->forPermission(auth()->user())
            ->with('category');

        if ($query) {
            $downloadablesQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('long_description', 'like', "%{$query}%");
            });
        }

        if ($categoryId) {
            $downloadablesQuery->where('download_category_id', $categoryId);
        }

        if ($format) {
            $downloadablesQuery->where('format', $format);
        }

        // Tri
        switch ($request->input('sort', 'relevance')) {
            case 'title':
                $downloadablesQuery->orderBy('title', 'asc');
                break;
            case 'downloads':
                $downloadablesQuery->orderBy('download_count', 'desc');
                break;
            case 'recent':
                $downloadablesQuery->orderBy('created_at', 'desc');
                break;
            default:
                $downloadablesQuery->orderBy('download_count', 'desc');
                break;
        }

        $downloadables = $downloadablesQuery->paginate(12)->appends($request->query());

        $categories = DownloadCategory::active()->orderBy('name')->get();
        $formats = Downloadable::active()
            ->forPermission(auth()->user())
            ->distinct()
            ->pluck('format')
            ->sort();

        return view('public.ebook.search', compact('downloadables', 'categories', 'formats', 'query', 'categoryId', 'format'));
    }
}