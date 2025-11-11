<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * 🇬🇧 CatalogueModule model representing a module in the catalogue
 * 🇫🇷 Modèle CatalogueModule représentant un module dans le catalogue
 * 
 * @file app/Models/CatalogueModule.php
 */
class CatalogueModule extends Model
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
        'catalogue_section_id',
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

        static::creating(function ($module) {
            if (auth()->check()) {
                $module->created_by = auth()->id();
            }
            
            if (empty($module->slug)) {
                $module->slug = Str::slug($module->name);
            }
        });

        static::updating(function ($module) {
            if (auth()->check()) {
                $module->updated_by = auth()->id();
            }
            
            if ($module->isDirty('name') && empty($module->slug)) {
                $module->slug = Str::slug($module->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the section that owns this module
     * 🇫🇷 Obtenir la section à laquelle appartient ce module
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(CatalogueSection::class, 'catalogue_section_id');
    }

    /**
     * 🇬🇧 Get the units that belong to this module
     * 🇫🇷 Obtenir les unités qui appartiennent à ce module
     */
    public function units(): HasMany
    {
        return $this->hasMany(CatalogueUnit::class, 'catalogue_module_id');
    }

    /**
     * 🇬🇧 Get only active units for this module
     * 🇫🇷 Obtenir uniquement les unités actives pour ce module
     */
    public function activeUnits(): HasMany
    {
        return $this->units()->where('is_active', true)->orderBy('order', 'asc');
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
     * 🇬🇧 Scope for active modules
     * 🇫🇷 Scope pour les modules actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for ordered modules
     * 🇫🇷 Scope pour les modules ordonnés
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * 🇬🇧 Scope for modules by section
     * 🇫🇷 Scope pour les modules par section
     */
    public function scopeBySection($query, $sectionId)
    {
        return $query->where('catalogue_section_id', $sectionId);
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
     * 🇬🇧 Get the full URL of this module
     * 🇫🇷 Obtenir l'URL complète de ce module
     */
    public function getUrlAttribute(): string
    {
        if ($this->section) {
            return route('public.catalogue.module', [$this->section->slug, $this->slug]);
        }
        return '#';
    }
}