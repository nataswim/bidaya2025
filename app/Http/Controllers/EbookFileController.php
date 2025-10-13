<?php

namespace App\Http\Controllers;

use App\Models\EbookFile;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookFileController extends Controller
{
    private function checkAdminAccess()
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('editor')) {
            abort(403, 'Accès non autorisé');
        }
    }

    /**
     * Liste des fichiers eBooks
     */
    public function index(Request $request)
    {
        $this->checkAdminAccess();

        $search = $request->input('search');
        $format = $request->input('format');
        $perPage = $request->input('per_page', 20);

        $query = EbookFile::with('uploader')
            ->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($format) {
            $query->where('format', $format);
        }

        $files = $query->paginate($perPage);
        $stats = $this->getStats();

        return view('admin.ebook-files.index', compact('files', 'stats', 'search', 'format'));
    }

    /**
     * Uploader des fichiers
     */
    public function store(Request $request)
    {
        $this->checkAdminAccess();

        $request->validate([
            'files.*' => 'required|file|mimes:pdf,epub,mp4,zip,doc,docx|max:204800', // 200MB max
            'names.*' => 'nullable|string|max:255',
            'descriptions.*' => 'nullable|string|max:1000',
        ]);

        $uploadedFiles = [];
        $files = $request->file('files');
        $names = $request->input('names', []);
        $descriptions = $request->input('descriptions', []);

        foreach ($files as $index => $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $customName = $names[$index] ?? null;
                $description = $descriptions[$index] ?? null;
                
                $uploadedFiles[] = $this->uploadFile($file, $customName, $description);
            }
        }

        $count = count($uploadedFiles);
        $message = $count === 1 
            ? 'Fichier uploadé avec succès.' 
            : "{$count} fichiers uploadés avec succès.";

        return redirect()->route('admin.ebook-files.index')
            ->with('success', $message);
    }

    /**
     * Afficher un fichier
     */
    public function show(EbookFile $ebookFile)
    {
        $this->checkAdminAccess();
        
        $ebookFile->load(['uploader', 'downloadables']);
        
        return view('admin.ebook-files.show', compact('ebookFile'));
    }

    /**
     * Mettre à jour un fichier
     */
    public function update(Request $request, EbookFile $ebookFile)
    {
        $this->checkAdminAccess();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $ebookFile->update($request->only(['name', 'description']));

        return redirect()->route('admin.ebook-files.show', $ebookFile)
            ->with('success', 'Fichier mis à jour avec succès.');
    }

    /**
     * Supprimer un fichier
     */
    public function destroy(EbookFile $ebookFile)
    {
        $this->checkAdminAccess();
        
        // Vérifier s'il est utilisé par des downloadables
        if ($ebookFile->downloadables()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer ce fichier car il est utilisé par ' . $ebookFile->downloadables()->count() . ' téléchargement(s).');
        }
        
        $ebookFile->delete();

        return redirect()->route('admin.ebook-files.index')
            ->with('success', 'Fichier supprimé avec succès.');
    }

    /**
     * API pour sélectionner des fichiers (modal)
     */
    public function api(Request $request)
    {
        $this->checkAdminAccess();

        $search = $request->input('search');
        $format = $request->input('format');
        $page = $request->input('page', 1);
        $perPage = 12;

        $query = EbookFile::latest();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($format) {
            $query->where('format', $format);
        }

        $files = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $files->items(),
            'current_page' => $files->currentPage(),
            'last_page' => $files->lastPage(),
            'total' => $files->total(),
        ]);
    }

    /**
     * Actions en masse
     */
    public function bulkAction(Request $request)
    {
        $this->checkAdminAccess();

        $request->validate([
            'action' => 'required|in:delete',
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:ebook_files,id',
        ]);

        $fileIds = $request->input('file_ids');
        $action = $request->input('action');

        if ($action === 'delete') {
            $files = EbookFile::whereIn('id', $fileIds)->get();
            $deleted = 0;
            $errors = 0;

            foreach ($files as $file) {
                if ($file->downloadables()->count() > 0) {
                    $errors++;
                    continue;
                }
                $file->delete();
                $deleted++;
            }

            $message = "{$deleted} fichier(s) supprimé(s).";
            if ($errors > 0) {
                $message .= " {$errors} fichier(s) non supprimé(s) car utilisé(s).";
            }

            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'Action non reconnue.');
    }

    // ========== MÉTHODES PRIVÉES ==========

    /**
     * Upload d'un fichier
     */
    private function uploadFile(UploadedFile $file, ?string $customName = null, ?string $description = null): EbookFile
    {
        // Générer un nom unique pour le fichier
        $fileName = $this->generateUniqueFileName($file);
        
        // Créer le dossier ebooks s'il n'existe pas
        $ebookPath = 'ebooks';
        if (!Storage::disk('local')->exists($ebookPath)) {
            Storage::disk('local')->makeDirectory($ebookPath);
        }
        
        // Chemin complet
        $filePath = $ebookPath . '/' . $fileName;
        
        // Stocker le fichier dans storage/app/ebooks
        Storage::disk('local')->putFileAs($ebookPath, $file, $fileName);
        
        // Déterminer le format
        $extension = strtolower($file->getClientOriginalExtension());
        $format = in_array($extension, ['pdf', 'epub', 'mp4', 'zip', 'doc', 'docx']) ? $extension : 'other';
        
        // Créer l'enregistrement en base
        return EbookFile::create([
            'name' => $customName ?: $this->cleanFileName($file->getClientOriginalName()),
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'format' => $format,
            'mime_type' => $file->getMimeType(),
            'path' => $filePath,
            'size' => $file->getSize(),
            'description' => $description,
        ]);
    }

    /**
     * Générer un nom de fichier unique
     */
    private function generateUniqueFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = Str::random(8);
        
        return $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Nettoyer le nom du fichier pour l'affichage
     */
    private function cleanFileName(string $originalName): string
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        return Str::title(str_replace(['_', '-'], ' ', $name));
    }

    /**
     * Obtenir les statistiques
     */
    private function getStats(): array
    {
        $totalFiles = EbookFile::count();
        $totalSize = EbookFile::sum('size');
        $recentUploads = EbookFile::where('created_at', '>=', now()->subDays(7))->count();
        $unusedFiles = EbookFile::unused()->count();
        
        $byFormat = EbookFile::selectRaw('format, count(*) as count, sum(size) as total_size')
            ->groupBy('format')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->format => [
                    'count' => $item->count,
                    'size' => $item->total_size,
                ]];
            });
        
        return [
            'total_files' => $totalFiles,
            'total_size' => $totalSize,
            'total_size_formatted' => $this->formatBytes($totalSize),
            'recent_uploads' => $recentUploads,
            'unused_files' => $unusedFiles,
            'by_format' => $byFormat,
        ];
    }

    /**
     * Formater les bytes
     */
    private function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}