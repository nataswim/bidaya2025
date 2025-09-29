<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 Fiche model representing a professional sheet in the system
 * 🇫🇷 Modèle Fiche représentant une fiche professionnelle dans le système
 * 
 * @file app/Models/Fiche.php
 */
class Fiche extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'image',
        'visibility',
        'is_published',
        'is_featured',
        'views_count',
        'sort_order',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_og_image',
        'meta_og_url',
        'created_by',
        'created_by_name',
        'updated_by',
        'deleted_by',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 🇬🇧 Boot the model
     * 🇫🇷 Démarrer le modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fiche) {
            if (auth()->check()) {
                $fiche->created_by = auth()->id();
                $fiche->created_by_name = auth()->user()->name;
            }
            
            // 🇬🇧 Auto-generate slug / 🇫🇷 Génération automatique du slug
            if (empty($fiche->slug)) {
                $fiche->slug = Str::slug($fiche->title);
            }
            
            // 🇬🇧 Set published_at when published / 🇫🇷 Définir published_at lors de la publication
            if ($fiche->is_published && !$fiche->published_at) {
                $fiche->published_at = now();
            }
        });

        static::updating(function ($fiche) {
            if (auth()->check()) {
                $fiche->updated_by = auth()->id();
            }
            
            // 🇬🇧 Update published_at when first published / 🇫🇷 Mettre à jour published_at lors de la première publication
            if ($fiche->isDirty('is_published') && $fiche->is_published && !$fiche->published_at) {
                $fiche->published_at = now();
            }
        });
    }

    /**
     * 🇬🇧 Get the creator of this fiche
     * 🇫🇷 Obtenir le créateur de cette fiche
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * 🇬🇧 Get the updater of this fiche
     * 🇫🇷 Obtenir le modificateur de cette fiche
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * 🇬🇧 Get the categories that belong to this fiche
     * 🇫🇷 Obtenir les catégories qui appartiennent à cette fiche
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(FichesCategory::class, 'fiches_fiches_category', 'fiche_id', 'fiches_category_id')
                    ->withTimestamps()
                    ->orderBy('sort_order');
    }

    /**
     * 🇬🇧 Get only active categories
     * 🇫🇷 Obtenir uniquement les catégories actives
     */
    public function activeCategories(): BelongsToMany
    {
        return $this->categories()->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for published fiches
     * 🇫🇷 Scope pour les fiches publiées
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * 🇬🇧 Scope for featured fiches
     * 🇫🇷 Scope pour les fiches mises en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * 🇬🇧 Scope for ordered fiches
     * 🇫🇷 Scope pour les fiches ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('published_at', 'desc');
    }

    /**
     * 🇬🇧 Scope for fiches by category
     * 🇫🇷 Scope pour les fiches par catégorie
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('fiches_categories.id', $categoryId);
        });
    }

    /**
     * 🇬🇧 Scope for visible fiches according to user
     * 🇫🇷 Scope pour les fiches visibles selon l'utilisateur
     */
    public function scopeVisibleTo($query, $user = null)
    {
        return $query->where(function($q) use ($user) {
            // 🇬🇧 Public fiches / 🇫🇷 Fiches publiques
            $q->where('is_published', true)
              ->whereNotNull('published_at')
              ->where('published_at', '<=', now())
              ->where('visibility', 'public');
            
            // 🇬🇧 If user authenticated, add authenticated fiches / 🇫🇷 Si utilisateur authentifié, ajouter les fiches authentifiées
            if ($user) {
                $q->orWhere(function($subQ) {
                    $subQ->where('is_published', true)
                         ->whereNotNull('published_at')
                         ->where('published_at', '<=', now())
                         ->where('visibility', 'authenticated');
                });
            }
            
            // 🇬🇧 If admin/editor, see all / 🇫🇷 Si admin/éditeur, tout voir
            if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
                $q->orWhere(function($subQ) {
                    $subQ->whereIn('is_published', [false, true]);
                });
            }
        });
    }

    /**
     * 🇬🇧 Check if user can view content
     * 🇫🇷 Vérifier si l'utilisateur peut voir le contenu
     */
    public function canViewContent($user = null): bool
    {
        // 🇬🇧 Admins/editors always see content / 🇫🇷 Admins/éditeurs voient toujours le contenu
        if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
            return true;
        }
        
        // 🇬🇧 If not published, only admins can see / 🇫🇷 Si non publié, seuls les admins peuvent voir
        if (!$this->is_published) {
            return false;
        }
        
        // 🇬🇧 Check visibility / 🇫🇷 Vérifier la visibilité
        if ($this->visibility === 'public') {
            return true;
        }
        
        if ($this->visibility === 'authenticated') {
            return $user !== null;
        }
        
        return false;
    }

    /**
     * 🇬🇧 Get the full URL of this fiche
     * 🇫🇷 Obtenir l'URL complète de cette fiche
     */
    public function getUrlAttribute(): string
    {
        return route('public.fiches.show', $this->slug);
    }

    /**
     * 🇬🇧 Get excerpt from content
     * 🇫🇷 Obtenir un extrait du contenu
     */
    public function getExcerptAttribute(): string
    {
        if ($this->short_description) {
            return $this->short_description;
        }
        
        return Str::limit(strip_tags($this->long_description), 160);
    }

    /**
     * 🇬🇧 Increment views count
     * 🇫🇷 Incrémenter le compteur de vues
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * 🇬🇧 Get the route key name for model binding
     * 🇫🇷 Obtenir le nom de la clé de route pour la liaison du modèle
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}