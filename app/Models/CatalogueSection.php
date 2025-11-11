<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * 🇬🇧 CatalogueSection model representing a section in the catalogue
 * 🇫🇷 Modèle CatalogueSection représentant une section dans le catalogue
 * 
 * @file app/Models/CatalogueSection.php
 */
class CatalogueSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'image',
        'is_active',
        'order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
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

        static::creating(function ($section) {
            if (auth()->check()) {
                $section->created_by = auth()->id();
            }
            
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });

        static::updating(function ($section) {
            if (auth()->check()) {
                $section->updated_by = auth()->id();
            }
            
            if ($section->isDirty('name') && empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the modules that belong to this section
     * 🇫🇷 Obtenir les modules qui appartiennent à cette section
     */
    public function modules(): HasMany
    {
        return $this->hasMany(CatalogueModule::class, 'catalogue_section_id');
    }

    /**
     * 🇬🇧 Get only active modules for this section
     * 🇫🇷 Obtenir uniquement les modules actifs pour cette section
     */
    public function activeModules(): HasMany
    {
        return $this->modules()->where('is_active', true)->orderBy('order', 'asc');
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
     * 🇬🇧 Get the updater
     * 🇫🇷 Obtenir le modificateur
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * 🇬🇧 Scope for active sections
     * 🇫🇷 Scope pour les sections actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for ordered sections
     * 🇫🇷 Scope pour les sections ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * 🇬🇧 Get the route key name for model binding
     * 🇫🇷 Obtenir le nom de la clé de route pour la liaison du modèle
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * 🇬🇧 Get the full URL of this section
     * 🇫🇷 Obtenir l'URL complète de cette section
     */
    public function getUrlAttribute(): string
    {
        return route('public.catalogue.section', $this->slug);
    }
}