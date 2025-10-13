<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class EbookFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'original_name',
        'format',
        'mime_type',
        'path',
        'size',
        'description',
        'uploaded_by',
        'used_at'
    ];

    protected $casts = [
        'size' => 'integer',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'uploader
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relation avec les downloadables
     */
    public function downloadables()
    {
        return $this->hasMany(Downloadable::class, 'ebook_file_id');
    }

    /**
     * URL publique du fichier (pour téléchargement)
     */
    public function getUrlAttribute()
    {
        // Les fichiers eBooks sont dans storage/app/ebooks (private)
        // On ne retourne pas d'URL directe, le téléchargement se fait via controller
        return null;
    }

    /**
     * Chemin physique complet
     */
    public function getPhysicalPathAttribute()
    {
        return Storage::disk('local')->path($this->path);
    }

    /**
     * Taille formatée
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
     * Icône selon le format
     */
    public function getIconAttribute()
    {
        $icons = [
            'pdf' => 'fa-file-pdf',
            'epub' => 'fa-book',
            'mp4' => 'fa-file-video',
            'zip' => 'fa-file-archive',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
        ];
        
        return $icons[$this->format] ?? 'fa-file';
    }

    /**
     * Label du format
     */
    public function getFormatLabelAttribute()
    {
        $labels = [
            'pdf' => 'PDF',
            'epub' => 'EPUB',
            'mp4' => 'Vidéo MP4',
            'zip' => 'Archive ZIP',
            'doc' => 'Word DOC',
            'docx' => 'Word DOCX',
        ];
        
        return $labels[$this->format] ?? strtoupper($this->format);
    }

    /**
     * Marquer comme utilisé
     */
    public function markAsUsed()
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Vérifier si le fichier existe physiquement
     */
    public function fileExists()
    {
        return Storage::disk('local')->exists($this->path);
    }

    /**
     * Scopes
     */
    public function scopeByFormat($query, $format)
    {
        return $query->where('format', $format);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeUnused($query)
    {
        return $query->whereNull('used_at');
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ebookFile) {
            if (auth()->check()) {
                $ebookFile->uploaded_by = auth()->id();
            }
        });

        // Supprimer le fichier physique lors de la suppression
        static::deleting(function ($ebookFile) {
            if (Storage::disk('local')->exists($ebookFile->path)) {
                Storage::disk('local')->delete($ebookFile->path);
            }
        });
    }
}