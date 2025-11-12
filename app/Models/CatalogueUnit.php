<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 🇬🇧 CatalogueUnit model representing a unit in the catalogue
 * 🇫🇷 Modèle CatalogueUnit représentant une unité dans le catalogue
 * 
 * @file app/Models/CatalogueUnit.php
 */
class CatalogueUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'order',
        'catalogue_module_id',
        'unitable_type',
        'unitable_id',
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

        static::creating(function ($unit) {
            if (auth()->check()) {
                $unit->created_by = auth()->id();
            }

            if (empty($unit->slug)) {
                $unit->slug = Str::slug($unit->title);
            }
        });

        static::updating(function ($unit) {
            if (auth()->check()) {
                $unit->updated_by = auth()->id();
            }

            if ($unit->isDirty('title') && empty($unit->slug)) {
                $unit->slug = Str::slug($unit->title);
            }
        });
    }

    /**
     * 🇬🇧 Get the module that owns this unit
     * 🇫🇷 Obtenir le module auquel appartient cette unité
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(CatalogueModule::class, 'catalogue_module_id');
    }

    /**
     * 🇬🇧 Get the polymorphic content
     * 🇫🇷 Obtenir le contenu polymorphique
     */
    public function unitable(): MorphTo
    {
        return $this->morphTo();
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
     * 🇬🇧 Scope for active units
     * 🇫🇷 Scope pour les unités actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 🇬🇧 Scope for ordered units
     * 🇫🇷 Scope pour les unités ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('title', 'asc');
    }

    /**
     * 🇬🇧 Scope for units by module
     * 🇫🇷 Scope pour les unités par module
     */
    public function scopeByModule($query, $moduleId)
    {
        return $query->where('catalogue_module_id', $moduleId);
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
     * 🇬🇧 Get the full URL of this unit
     * 🇫🇷 Obtenir l'URL complète de cette unité
     */
    public function getUrlAttribute(): string
    {
        if ($this->module && $this->module->section) {
            return route('public.catalogue.unit', [
                $this->module->section->slug,
                $this->module->slug,
                $this->slug
            ]);
        }
        return '#';
    }

    /**
     * 🇬🇧 Get the content type label
     * 🇫🇷 Obtenir le libellé du type de contenu
     */
    public function getContentTypeLabelAttribute(): string
    {
        if (!$this->unitable_type) {
            return 'Non défini';
        }

        $types = [
            'App\Models\Post' => 'Article',
            'App\Models\Video' => 'Vidéo',
            'App\Models\Downloadable' => 'Fichier téléchargeable',
            'App\Models\Fiche' => 'Fiche',
            'App\Models\Exercice' => 'Exercice',
            'App\Models\Workout' => 'Entraînement',
            'App\Models\EbookFile' => 'E-book',
        ];

        return $types[$this->unitable_type] ?? 'Autre';
    }

    /**
     * 🇬🇧 Get the content URL
     * 🇫🇷 Obtenir l'URL du contenu
     */
    public function getContentUrlAttribute(): ?string
    {
        if (!$this->unitable) {
            return null;
        }

        // Retourner l'URL selon le type de contenu
        if (method_exists($this->unitable, 'getUrlAttribute')) {
            return $this->unitable->url;
        }

        return null;
    }

    /**
     * Relation vers les contenus multiples
     */
    public function contents(): HasMany
    {
        return $this->hasMany(CatalogueUnitContent::class, 'catalogue_unit_id');
    }

    /**
     * Obtenir les contenus actifs et ordonnés
     */
    public function activeContents()
    {
        return $this->contents()
            ->active()
            ->ordered()
            ->with('contentable');
    }

    /**
     * Vérifier si l'unité a des contenus
     */
    public function getHasContentsAttribute(): bool
    {
        return $this->contents()->exists();
    }

    /**
     * Obtenir le nombre de contenus
     */
    public function getContentsCountAttribute(): int
    {
        return $this->contents()->count();
    }

    /**
     * Obtenir le premier contenu (pour compatibilité)
     */
    public function getFirstContentAttribute()
    {
        return $this->contents()->ordered()->first();
    }

    /**
     * Obtenir les types de contenus présents
     */
    public function getContentTypesAttribute(): array
    {
        return $this->contents()
            ->distinct('contentable_type')
            ->pluck('contentable_type')
            ->map(function ($type) {
                $types = [
                    'App\Models\Post' => 'Articles',
                    'App\Models\Video' => 'Vidéos',
                    'App\Models\Downloadable' => 'Téléchargements',
                    'App\Models\Fiche' => 'Fiches',
                    'App\Models\Exercice' => 'Exercices',
                    'App\Models\Workout' => 'Entraînements',
                    'App\Models\EbookFile' => 'E-books',
                ];
                return $types[$type] ?? 'Autres';
            })
            ->toArray();
    }
}
