<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * Video Model
 * 
 * @file app/Models/Video.php
 */
class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'file_path',
        'file_size',
        'mime_type',
        'external_url',
        'external_id',
        'thumbnail',
        'duration',
        'width',
        'height',
        'visibility',
        'is_published',
        'is_featured',
        'sort_order',
        'views_count',
        'created_by',
        'created_by_name',
        'updated_by',
        'deleted_by',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'sort_order' => 'integer',
        'duration' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (auth()->check()) {
                $video->created_by = auth()->id();
                $video->created_by_name = auth()->user()->name;
            }
            
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
            }
            
            if ($video->is_published && !$video->published_at) {
                $video->published_at = now();
            }
        });

        static::updating(function ($video) {
            if (auth()->check()) {
                $video->updated_by = auth()->id();
            }
            
            if ($video->isDirty('is_published') && $video->is_published && !$video->published_at) {
                $video->published_at = now();
            }
        });
    }

    /**
     * Relation : Catégories de la vidéo
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(VideoCategory::class, 'category_video');
    }

    /**
     * Relation : Créateur
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relation : Modificateur
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope : Vidéos publiées
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope : Vidéos en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope : Vidéos ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('published_at', 'desc');
    }

    /**
     * Scope : Vidéos visibles selon l'utilisateur
     */
    public function scopeVisibleTo($query, $user = null)
    {
        return $query->where(function($q) use ($user) {
            $q->where('is_published', true)
              ->whereNotNull('published_at')
              ->where('published_at', '<=', now())
              ->where('visibility', 'public');
            
            if ($user && !$user->hasRole('visitor')) {
                $q->orWhere(function($subQ) {
                    $subQ->where('is_published', true)
                         ->whereNotNull('published_at')
                         ->where('published_at', '<=', now())
                         ->where('visibility', 'authenticated');
                });
            }
            
            if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
                $q->orWhere(function($subQ) {
                    $subQ->whereIn('is_published', [false, true]);
                });
            }
        });
    }

    /**
     * Vérifier si l'utilisateur peut voir le contenu
     */
    public function canViewContent($user = null): bool
    {
        if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
            return true;
        }
        
        if (!$this->is_published) {
            return false;
        }
        
        if ($this->visibility === 'public') {
            return true;
        }
        
        if ($this->visibility === 'authenticated') {
            return $user !== null && !$user->hasRole('visitor');
        }
        
        return false;
    }

    /**
     * Obtenir l'URL de la vidéo
     */
    public function getVideoUrl(): string
    {
        if ($this->type === 'upload' && $this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        if ($this->external_url) {
            return $this->external_url;
        }
        
        return '';
    }

    /**
     * Obtenir l'embed URL pour les plateformes externes
     */
    public function getEmbedUrl(): ?string
    {
        if ($this->type === 'youtube' && $this->external_id) {
            return "https://www.youtube.com/embed/{$this->external_id}";
        }
        
        if ($this->type === 'vimeo' && $this->external_id) {
            return "https://player.vimeo.com/video/{$this->external_id}";
        }
        
        if ($this->type === 'dailymotion' && $this->external_id) {
            return "https://www.dailymotion.com/embed/video/{$this->external_id}";
        }
        
        return null;
    }

    /**
     * Formater la durée
     */
    public function getFormattedDuration(): string
    {
        if (!$this->duration) {
            return 'N/A';
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Incrémenter le compteur de vues
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Route key pour le model binding
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}