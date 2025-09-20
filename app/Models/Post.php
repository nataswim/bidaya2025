<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'intro', 'content', 'type', 'category_id', 'category_name',
        'is_featured', 'image', 'meta_title', 'meta_keywords', 'meta_description',
        'meta_og_image', 'meta_og_url', 'hits', 'order', 'status', 'visibility',
        'moderated_by', 'moderated_at', 'created_by', 'created_by_name', 
        'created_by_alias', 'updated_by', 'deleted_by', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'moderated_at' => 'datetime',
        'is_featured' => 'boolean',
        'hits' => 'integer',
        'order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    /**
     * Les métadonnées (titre, intro, image) sont toujours visibles si le post est publié
     */
    public function isMetadataVisible(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }

    /**
     * Vérifier si le contenu complet est visible pour l'utilisateur actuel
     */
    public function isContentVisibleTo($user = null): bool
    {
        // Si le post n'est pas publié, seuls les admins/éditeurs peuvent voir le contenu
        if (!$this->isMetadataVisible()) {
            return $user && ($user->hasRole('admin') || $user->hasRole('editor'));
        }
        
        // Si la visibilité est publique, tout le monde peut voir le contenu
        if ($this->visibility === 'public') {
            return true;
        }
        
        // Si la visibilité est "authenticated", il faut être connecté pour voir le contenu
        if ($this->visibility === 'authenticated') {
            return $user !== null;
        }
        
        return false;
    }

    /**
     * Scope pour les posts avec métadonnées visibles
     */
    public function scopeWithMetadataVisible($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope pour les posts visibles (métadonnées + contenu selon utilisateur)
     */
    public function scopeVisibleTo($query, $user = null)
    {
        return $query->where(function($q) use ($user) {
            // Posts publics et publiés
            $q->where('status', 'published')
              ->whereNotNull('published_at')
              ->where('published_at', '<=', now())
              ->where('visibility', 'public');
            
            // Si utilisateur connecté, ajouter les posts pour utilisateurs authentifiés
            if ($user) {
                $q->orWhere(function($subQ) use ($user) {
                    $subQ->where('status', 'published')
                         ->whereNotNull('published_at')
                         ->where('published_at', '<=', now())
                         ->where('visibility', 'authenticated');
                });
            }
            
            // Si admin/éditeur, voir tous les posts
            if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
                $q->orWhere(function($subQ) {
                    // Voir tous les posts, même les brouillons
                    $subQ->whereIn('status', ['draft', 'published']);
                });
            }
        });
    }

    /**
     * Scope pour les posts publiés uniquement
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope pour les posts mis en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Accessor pour l'URL de l'article
     */
    public function getUrlAttribute()
    {
        return route('public.show', $this->slug);
    }

    /**
     * Accessor pour le résumé du contenu
     */
    public function getExcerptAttribute()
    {
        if ($this->intro) {
            return $this->intro;
        }
        
        return \Str::limit(strip_tags($this->content), 160);
    }

    /**
     * Accessor pour le temps de lecture estimé
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // 200 mots par minute en moyenne
        
        return $readingTime;
    }

    /**
     * Mutator pour générer automatiquement le slug
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    /**
     * Boot method pour les événements du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (auth()->check()) {
                $post->created_by = auth()->id();
                $post->created_by_name = auth()->user()->name;
            }
        });

        static::updating(function ($post) {
            if (auth()->check()) {
                $post->updated_by = auth()->id();
            }
        });
    }
}