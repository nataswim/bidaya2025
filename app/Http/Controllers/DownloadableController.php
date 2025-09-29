<?php

namespace App\Http\Controllers;

use App\Models\Downloadable;
use App\Models\DownloadCategory;
use App\Models\DownloadLog;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDownloadableRequest;
use App\Http\Requests\UpdateDownloadableRequest;
use Illuminate\Support\Facades\Storage;

class DownloadableController extends Controller
{
    private function checkAdminAccess()
{
    $user = auth()->user();
    
    if (!$user || !$user->role) {
        abort(403, 'Acces non autorise - Aucun rôle assigne');
    }
    
    if (!$user->hasRole('admin') && !$user->hasRole('editor')) {
        abort(403, 'Acces non autorise');
    }
}

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        $search = $request->input('search');
        $status = $request->input('status');
        $permission = $request->input('permission');
        $categoryId = $request->input('category');
        $format = $request->input('format');
        
        $query = Downloadable::with(['category', 'creator']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($permission) {
            $query->where('user_permission', $permission);
        }

        if ($categoryId) {
            $query->where('download_category_id', $categoryId);
        }

        if ($format) {
            $query->where('format', $format);
        }

        $downloadables = $query->orderBy('created_at', 'desc')
                              ->orderBy('order', 'asc')
                              ->paginate(15);

        $categories = DownloadCategory::where('status', 'active')->orderBy('name')->get();

        return view('admin.downloadables.index', compact(
            'downloadables', 
            'categories', 
            'search', 
            'status', 
            'permission', 
            'categoryId',
            'format'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $categories = DownloadCategory::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.downloadables.create', compact('categories'));
    }

    public function store(StoreDownloadableRequest $request)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // Gerer l'upload du fichier
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('downloads', $filename, 'local');
            
            $data['file_path'] = $filePath;
            $data['file_size'] = $this->formatFileSize($file->getSize());
        }
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        $downloadable = Downloadable::create($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.downloadables.edit', $downloadable)
                ->with('success', 'Telechargement cree avec succes. Vous pouvez continuer A l\'editer.');
        }

        return redirect()->route('admin.downloadables.index')
            ->with('success', 'Telechargement cree avec succes.');
    }

    public function show(Downloadable $downloadable)
    {
        $this->checkAdminAccess();
        
        $downloadable->load(['category', 'creator', 'updater']);
        
        // Statistiques recentes
        $recentDownloads = DownloadLog::where('downloadable_id', $downloadable->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $downloadStats = [
            'today' => DownloadLog::where('downloadable_id', $downloadable->id)
                ->whereDate('created_at', today())
                ->count(),
            'this_week' => DownloadLog::where('downloadable_id', $downloadable->id)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => DownloadLog::where('downloadable_id', $downloadable->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('admin.downloadables.show', compact('downloadable', 'recentDownloads', 'downloadStats'));
    }

    public function edit(Downloadable $downloadable)
    {
        $this->checkAdminAccess();
        
        $categories = DownloadCategory::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.downloadables.edit', compact('downloadable', 'categories'));
    }

    public function update(UpdateDownloadableRequest $request, Downloadable $downloadable)
    {
        $this->checkAdminAccess();
        
        $data = $request->validated();
        
        // Gerer l'upload d'un nouveau fichier
        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($downloadable->file_path && Storage::disk('local')->exists($downloadable->file_path)) {
                Storage::disk('local')->delete($downloadable->file_path);
            }
            
            $file = $request->file('file');
            $filename = time() . '_' . \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('downloads', $filename, 'local');
            
            $data['file_path'] = $filePath;
            $data['file_size'] = $this->formatFileSize($file->getSize());
        }
        
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }
        
        $downloadable->update($data);

        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_continue') {
            return redirect()->route('admin.downloadables.edit', $downloadable)
                ->with('success', 'Telechargement mis A jour avec succes.');
        }

        return redirect()->route('admin.downloadables.index')
            ->with('success', 'Telechargement mis A jour avec succes.');
    }

    public function destroy(Downloadable $downloadable)
    {
        $this->checkAdminAccess();
        
        // Supprimer le fichier
        if ($downloadable->file_path && Storage::disk('local')->exists($downloadable->file_path)) {
            Storage::disk('local')->delete($downloadable->file_path);
        }
        
        $downloadable->delete();

        return redirect()->route('admin.downloadables.index')
            ->with('success', 'Telechargement supprime avec succes.');
    }

    /**
     * Dupliquer un telechargement
     */
    public function duplicate(Downloadable $downloadable)
    {
        $this->checkAdminAccess();
        
        $newDownloadable = $downloadable->replicate();
        $newDownloadable->title = $downloadable->title . ' (Copie)';
        $newDownloadable->slug = \Str::slug($newDownloadable->title);
        $newDownloadable->download_count = 0;
        $newDownloadable->status = 'inactive';
        $newDownloadable->save();

        return redirect()->route('admin.downloadables.edit', $newDownloadable)
            ->with('success', 'Telechargement duplique avec succes.');
    }

    /**
     * Statistiques detaillees
     */
    public function stats()
    {
        $this->checkAdminAccess();
        
        $stats = [
            'total' => Downloadable::count(),
            'active' => Downloadable::where('status', 'active')->count(),
            'inactive' => Downloadable::where('status', 'inactive')->count(),
            'featured' => Downloadable::where('is_featured', true)->count(),
            'by_permission' => Downloadable::selectRaw('user_permission, count(*) as count')
                ->groupBy('user_permission')
                ->get()
                ->pluck('count', 'user_permission'),
            'by_format' => Downloadable::selectRaw('format, count(*) as count')
                ->groupBy('format')
                ->get()
                ->pluck('count', 'format'),
            'total_downloads' => Downloadable::sum('download_count'),
            'most_downloaded' => Downloadable::where('status', 'active')
                ->orderBy('download_count', 'desc')
                ->limit(10)
                ->get(),
            'recent_downloads' => DownloadLog::with(['downloadable', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get(),
        ];

        return view('admin.downloadables.stats', compact('stats'));
    }

    /**
     * Actions en lot
     */
    public function bulkAction(Request $request)
    {
        $this->checkAdminAccess();
        
        $action = $request->input('action');
        $downloadableIds = $request->input('downloadables', []);
        
        if (empty($downloadableIds)) {
            return redirect()->back()->with('error', 'Aucun telechargement selectionne.');
        }
        
        $count = 0;
        
        switch ($action) {
            case 'activate':
                $count = Downloadable::whereIn('id', $downloadableIds)->update([
                    'status' => 'active',
                    'updated_by' => auth()->id()
                ]);
                $message = "{$count} telechargement(s) active(s).";
                break;
                
            case 'deactivate':
                $count = Downloadable::whereIn('id', $downloadableIds)->update([
                    'status' => 'inactive',
                    'updated_by' => auth()->id()
                ]);
                $message = "{$count} telechargement(s) desactive(s).";
                break;
                
            case 'feature':
                $count = Downloadable::whereIn('id', $downloadableIds)->update([
                    'is_featured' => true,
                    'updated_by' => auth()->id()
                ]);
                $message = "{$count} telechargement(s) mis en avant.";
                break;
                
            case 'unfeature':
                $count = Downloadable::whereIn('id', $downloadableIds)->update([
                    'is_featured' => false,
                    'updated_by' => auth()->id()
                ]);
                $message = "{$count} telechargement(s) retire(s) de la une.";
                break;
                
            case 'delete':
                foreach ($downloadableIds as $downloadableId) {
                    $downloadable = Downloadable::find($downloadableId);
                    if ($downloadable) {
                        // Supprimer le fichier
                        if ($downloadable->file_path && Storage::disk('local')->exists($downloadable->file_path)) {
                            Storage::disk('local')->delete($downloadable->file_path);
                        }
                        $downloadable->delete();
                        $count++;
                    }
                }
                $message = "{$count} telechargement(s) supprime(s).";
                break;
                
            default:
                return redirect()->back()->with('error', 'Action non reconnue.');
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Formater la taille de fichier
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}