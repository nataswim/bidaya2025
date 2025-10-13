<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * Service de gestion des vidéos
 * 
 * @file app/Services/VideoService.php
 */
class VideoService
{
    /**
     * Uploader un fichier vidéo
     */
    public function uploadVideo(UploadedFile $file): array
    {
        $filename = time() . '_' . \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('videos', $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Supprimer un fichier vidéo
     */
    public function deleteVideo(string $filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        return false;
    }

    /**
     * Récupérer les métadonnées depuis YouTube
     */
    public function getYoutubeMetadata(string $url): ?array
    {
        $videoId = $this->extractYoutubeId($url);
        if (!$videoId) {
            return null;
        }

        try {
            $response = Http::get("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v={$videoId}&format=json");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'external_id' => $videoId,
                    'title' => $data['title'] ?? null,
                    'thumbnail' => $data['thumbnail_url'] ?? null,
                    'width' => $data['width'] ?? null,
                    'height' => $data['height'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            \Log::error('YouTube metadata fetch failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Récupérer les métadonnées depuis Vimeo
     */
    public function getVimeoMetadata(string $url): ?array
    {
        $videoId = $this->extractVimeoId($url);
        if (!$videoId) {
            return null;
        }

        try {
            $response = Http::get("https://vimeo.com/api/oembed.json?url=https://vimeo.com/{$videoId}");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'external_id' => $videoId,
                    'title' => $data['title'] ?? null,
                    'thumbnail' => $data['thumbnail_url'] ?? null,
                    'width' => $data['width'] ?? null,
                    'height' => $data['height'] ?? null,
                    'duration' => $data['duration'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Vimeo metadata fetch failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Récupérer les métadonnées depuis Dailymotion
     */
    public function getDailymotionMetadata(string $url): ?array
    {
        $videoId = $this->extractDailymotionId($url);
        if (!$videoId) {
            return null;
        }

        try {
            $response = Http::get("https://api.dailymotion.com/video/{$videoId}?fields=id,title,thumbnail_url,duration,width,height");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'external_id' => $videoId,
                    'title' => $data['title'] ?? null,
                    'thumbnail' => $data['thumbnail_url'] ?? null,
                    'width' => $data['width'] ?? null,
                    'height' => $data['height'] ?? null,
                    'duration' => $data['duration'] ?? null,
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Dailymotion metadata fetch failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Extraire l'ID d'une URL YouTube
     */
    private function extractYoutubeId(string $url): ?string
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extraire l'ID d'une URL Vimeo
     */
    private function extractVimeoId(string $url): ?string
    {
        preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $url, $matches);
        return $matches[3] ?? null;
    }

    /**
     * Extraire l'ID d'une URL Dailymotion
     */
    private function extractDailymotionId(string $url): ?string
    {
        preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Formater la taille de fichier
     */
    private function formatFileSize(int $bytes): string
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