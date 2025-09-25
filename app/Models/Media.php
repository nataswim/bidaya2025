<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'original_name',
        'mime_type',
        'path',
        'size',
        'metadata',
        'alt_text',
        'description',
        'media_category_id',
        'uploaded_by',
        'used_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'size' => 'integer',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(MediaCategory::class, 'media_category_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * URL publique du fichier
     */
    /**
 * URL publique du fichier
 */
public function getUrlAttribute()
{
    // Verifier que le fichier existe
    if (Storage::disk('public')->exists($this->path)) {
        return url('/storage/' . $this->path);
    }
    
    // Retourner une URL par defaut si le fichier n'existe pas
    return url('/storage/default-image.jpg');
}

    /**
     * URL complete
     */
    public function getFullUrlAttribute()
    {
        return url($this->url);
    }

    /**
     * Taille formatee
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Verifier si c'est une image
     */
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Dimensions de l'image (si applicable)
     */
    public function getDimensionsAttribute()
    {
        if ($this->is_image && isset($this->metadata['width'], $this->metadata['height'])) {
            return $this->metadata['width'] . ' × ' . $this->metadata['height'];
        }
        
        return null;
    }

    /**
     * Marquer comme utilise
     */
    public function markAsUsed()
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Scope pour les images
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * Scope par categorie
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('media_category_id', $categoryId);
    }

    /**
     * Scope recents
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            if (auth()->check()) {
                $media->uploaded_by = auth()->id();
            }
        });

        // Supprimer le fichier physique lors de la suppression
        static::deleting(function ($media) {
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
        });
    }
}