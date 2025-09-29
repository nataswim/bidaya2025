<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 FichesCategory model representing a fiche category in the system
 * 🇫🇷 Modèle FichesCategory représentant une catégorie de fiche dans le système
 * 
 * @file app/Models/FichesCategory.php
 */
class FichesCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
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

        static::creating(function ($category) {
            if (auth()->check()) {
                $category->created_by = auth()->id();
            }
            
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (auth()->check()) {
                $category->updated_by = auth()->id();
            }
            
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the fiches that belong to this category
     * 🇫🇷 Obtenir les fiches qui appartiennent à cette catégorie
     */
    public function fiches(): HasMany
    {
        return $this->hasMany(Fiche::class, 'fiches_category_id');
    }

    /**
     * 🇬🇧 Get only published fiches for this category
     * 🇫🇷 Obtenir uniquement les fiches publiées pour cette catégorie
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
     * 🇬🇧 Scope for active categories
     * 🇫🇷 Scope pour les catégories actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for ordered categories
     * 🇫🇷 Scope pour les catégories ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('name', 'asc');
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