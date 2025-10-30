<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Video;

/**
 * Controller pour gérer la bibliothèque de vidéos locales
 * 
 * @file app/Http/Controllers/Admin/VideoLibraryController.php
 */
class VideoLibraryController extends Controller
{
    // Extensions vidéo supportées
    private $videoExtensions = ['mp4', 'webm', 'mov', 'avi', 'mkv', 'flv', 'wmv', 'mpeg', 'mpg', '3gp'];
    
    // Taille maximale en octets (200 Mo)
    private $maxFileSize = 209715200;

    /**
     * Vérifier les permissions admin
     */
    private function checkAdminAccess()
    {
        $user = auth()->user();
        
        if (!$user || !$user->role) {
            abort(403, 'Accès non autorisé - Aucun rôle assigné');
        }
        
        if (!$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux administrateurs');
        }
    }

    /**
     * Lister les vidéos et dossiers dans un répertoire
     */
    public function browse(Request $request)
    {
        $this->checkAdminAccess();
        
        $path = $request->input('path', '');
        $fullPath = 'media/video/' . ltrim($path, '/');
        
        // Vérifier que le chemin ne sort pas du dossier autorisé
        if (Str::contains($fullPath, '..') || !Str::startsWith($fullPath, 'media/video')) {
            return response()->json([
                'error' => 'Chemin non autorisé'
            ], 403);
        }
        
        // Vérifier l'existence du dossier
        if (!Storage::disk('local')->exists($fullPath)) {
            // Créer le dossier s'il n'existe pas
            Storage::disk('local')->makeDirectory($fullPath);
        }
        
        $items = [];
        $directories = Storage::disk('local')->directories($fullPath);
        $files = Storage::disk('local')->files($fullPath);
        
        // Récupérer les fichiers déjà utilisés
        $usedFiles = Video::where('type', 'upload')
            ->whereNotNull('file_path')
            ->pluck('file_path')
            ->map(function($path) {
                // Extraire le nom de fichier original (sans le timestamp)
                $basename = basename($path);
                // Retirer le pattern _timestamp.extension pour trouver le nom original
                return preg_replace('/_\d+\.([a-z0-9]+)$/i', '.$1', $basename);
            })
            ->toArray();
        
        // Ajouter les dossiers
        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $items[] = [
                'type' => 'directory',
                'name' => $dirName,
                'path' => str_replace('media/video/', '', $directory),
                'icon' => 'fas fa-folder'
            ];
        }
        
        // Ajouter les fichiers vidéo
        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            if (in_array($extension, $this->videoExtensions)) {
                $size = Storage::disk('local')->size($file);
                $fileName = basename($file);
                
                // Vérifier si le fichier est déjà utilisé
                $isUsed = false;
                foreach ($usedFiles as $usedFile) {
                    // Comparer avec le nom de fichier (sans chemin)
                    if ($fileName === $usedFile || Str::contains($usedFile, pathinfo($fileName, PATHINFO_FILENAME))) {
                        $isUsed = true;
                        break;
                    }
                }
                
                $items[] = [
                    'type' => 'file',
                    'name' => $fileName,
                    'path' => str_replace('media/video/', '', $file),
                    'size' => $this->formatBytes($size),
                    'sizeBytes' => $size,
                    'extension' => $extension,
                    'isValid' => $size <= $this->maxFileSize,
                    'isUsed' => $isUsed,
                    'icon' => 'fas fa-file-video'
                ];
            }
        }
        
        // Trier : dossiers d'abord, puis fichiers par nom
        usort($items, function($a, $b) {
            if ($a['type'] !== $b['type']) {
                return $a['type'] === 'directory' ? -1 : 1;
            }
            return strcmp($a['name'], $b['name']);
        });
        
        return response()->json([
            'success' => true,
            'currentPath' => $path,
            'items' => $items,
            'maxFileSize' => $this->formatBytes($this->maxFileSize)
        ]);
    }

    /**
     * Copier une vidéo de la bibliothèque vers storage public
     */
    public function import(Request $request)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $sourcePath = 'media/video/' . ltrim($request->path, '/');
        
        // Vérifications de sécurité
        if (Str::contains($sourcePath, '..') || !Str::startsWith($sourcePath, 'media/video')) {
            return response()->json([
                'error' => 'Chemin non autorisé'
            ], 403);
        }
        
        if (!Storage::disk('local')->exists($sourcePath)) {
            return response()->json([
                'error' => 'Fichier introuvable'
            ], 404);
        }
        
        // Vérifier la taille
        $size = Storage::disk('local')->size($sourcePath);
        if ($size > $this->maxFileSize) {
            return response()->json([
                'error' => 'Fichier trop volumineux (max 200 Mo)'
            ], 422);
        }
        
        // Créer un nom unique pour éviter les conflits
        $fileName = basename($sourcePath);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $uniqueName = $baseName . '_' . time() . '.' . $extension;
        
        // Chemin de destination dans public
        $destinationPath = 'videos/' . $uniqueName;
        
        // Copier le fichier (la source reste intacte dans media/video/)
        $content = Storage::disk('local')->get($sourcePath);
        Storage::disk('public')->put($destinationPath, $content);
        
        // Obtenir les informations du fichier
        $mimeType = Storage::disk('public')->mimeType($destinationPath);
        $fileSize = Storage::disk('public')->size($destinationPath);
        
        return response()->json([
            'success' => true,
            'data' => [
                'file_path' => $destinationPath,
                'file_size' => $this->formatBytes($fileSize),
                'mime_type' => $mimeType,
                'original_name' => $fileName
            ]
        ]);
    }

    /**
     * Formater la taille en octets
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Upload de vidéos via l'interface admin
     */
    public function upload(Request $request)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'video' => 'required|file|mimes:mp4,webm,mov,avi,mkv,flv,wmv,mpeg,mpg,3gp|max:204800', // 200 Mo
            'folder' => 'nullable|string'
        ]);
        
        $folder = $request->input('folder', '');
        $folderPath = 'media/video/' . ltrim($folder, '/');
        
        // Vérifications de sécurité
        if (Str::contains($folderPath, '..')) {
            return response()->json([
                'error' => 'Chemin non autorisé'
            ], 403);
        }
        
        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('local')->exists($folderPath)) {
            Storage::disk('local')->makeDirectory($folderPath);
        }
        
        $file = $request->file('video');
        $originalName = $file->getClientOriginalName();
        
        // Stocker le fichier
        $path = $file->storeAs($folderPath, $originalName, 'local');
        
        return response()->json([
            'success' => true,
            'message' => 'Vidéo uploadée avec succès',
            'file' => [
                'name' => $originalName,
                'path' => str_replace('media/video/', '', $path),
                'size' => $this->formatBytes($file->getSize())
            ]
        ]);
    }

    /**
     * Créer un nouveau dossier
     */
    public function createFolder(Request $request)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string'
        ]);
        
        $parentPath = $request->input('path', '');
        $folderName = Str::slug($request->name);
        $fullPath = 'media/video/' . ltrim($parentPath, '/') . '/' . $folderName;
        
        // Vérifications de sécurité
        if (Str::contains($fullPath, '..') || !Str::startsWith($fullPath, 'media/video')) {
            return response()->json([
                'error' => 'Chemin non autorisé'
            ], 403);
        }
        
        if (Storage::disk('local')->exists($fullPath)) {
            return response()->json([
                'error' => 'Ce dossier existe déjà'
            ], 422);
        }
        
        Storage::disk('local')->makeDirectory($fullPath);
        
        return response()->json([
            'success' => true,
            'message' => 'Dossier créé avec succès',
            'folder' => [
                'name' => $folderName,
                'path' => str_replace('media/video/', '', $fullPath)
            ]
        ]);
    }

    /**
     * Supprimer un fichier
     */
    public function deleteFile(Request $request)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $filePath = 'media/video/' . ltrim($request->path, '/');
        
        // Vérifications de sécurité
        if (Str::contains($filePath, '..') || !Str::startsWith($filePath, 'media/video')) {
            return response()->json([
                'error' => 'Chemin non autorisé'
            ], 403);
        }
        
        if (!Storage::disk('local')->exists($filePath)) {
            return response()->json([
                'error' => 'Fichier introuvable'
            ], 404);
        }
        
        Storage::disk('local')->delete($filePath);
        
        return response()->json([
            'success' => true,
            'message' => 'Fichier supprimé avec succès'
        ]);
    }
}