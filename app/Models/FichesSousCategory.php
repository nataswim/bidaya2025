<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 FichesSousCategory model representing a sub-category of fiches
 * 🇫🇷 Modèle FichesSousCategory représentant une sous-catégorie de fiches
 * 
 * @file app/Models/FichesSousCategory.php
 */
class FichesSousCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'fiches_category_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
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

        static::creating(function ($sousCategory) {
            if (auth()->check()) {
                $sousCategory->created_by = auth()->id();
            }
            
            if (empty($sousCategory->slug)) {
                $sousCategory->slug = Str::slug($sousCategory->name);
            }
        });

        static::updating(function ($sousCategory) {
            if (auth()->check()) {
                $sousCategory->updated_by = auth()->id();
            }
            
            if ($sousCategory->isDirty('name') && empty($sousCategory->slug)) {
                $sousCategory->slug = Str::slug($sousCategory->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the parent category
     * 🇫🇷 Obtenir la catégorie parente
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FichesCategory::class, 'fiches_category_id');
    }

    /**
     * 🇬🇧 Get the fiches that belong to this sub-category
     * 🇫🇷 Obtenir les fiches qui appartiennent à cette sous-catégorie
     */
    public function fiches(): HasMany
    {
        return $this->hasMany(Fiche::class, 'fiches_sous_category_id');
    }

    /**
     * 🇬🇧 Get only published fiches for this sub-category
     * 🇫🇷 Obtenir uniquement les fiches publiées pour cette sous-catégorie
     */
    public function publishedFiches(): HasMany
    {
        return $this->fiches()->where('is_published', true);
    }

    /**
     * 🇬🇧 Get the creator
     * 🇫🇷 Obtenir le créateur
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * 🇬🇧 Scope for active sub-categories
     * 🇫🇷 Scope pour les sous-catégories actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for ordered sub-categories
     * 🇫🇷 Scope pour les sous-catégories ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('name', 'asc');
    }

    /**
     * 🇬🇧 Scope for sub-categories by parent category
     * 🇫🇷 Scope pour les sous-catégories par catégorie parente
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('fiches_category_id', $categoryId);
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