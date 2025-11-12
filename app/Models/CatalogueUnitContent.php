<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modèle pour la relation entre une unité et ses contenus multiples
 */
class CatalogueUnitContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalogue_unit_id',
        'contentable_type',
        'contentable_id',
        'order',
        'custom_title',
        'custom_description',
        'duration_minutes',
        'is_required',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order' => 'integer',
        'duration_minutes' => 'integer',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($content) {
            if (auth()->check()) {
                $content->created_by = auth()->id();
            }
        });

        static::updating(function ($content) {
            if (auth()->check()) {
                $content->updated_by = auth()->id();
            }
        });
    }

    /**
     * Relation vers l'unité
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(CatalogueUnit::class, 'catalogue_unit_id');
    }

    /**
     * Relation polymorphe vers le contenu
     */
    public function contentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Obtenir le titre affiché (custom ou original)
     */
    public function getDisplayTitleAttribute(): string
    {
        if ($this->custom_title) {
            return $this->custom_title;
        }

        if ($this->contentable) {
            return $this->contentable->title ?? $this->contentable->name ?? 'Sans titre';
        }

        return 'Contenu non disponible';
    }

    /**
     * Obtenir le type de contenu formaté
     */
    public function getContentTypeLabelAttribute(): string
    {
        if (!$this->contentable_type) {
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

        return $types[$this->contentable_type] ?? 'Autre';
    }

    /**
     * Obtenir l'URL du contenu
     */
    public function getContentUrlAttribute(): ?string
    {
        if (!$this->contentable) {
            return null;
        }

        // Retourner l'URL selon le type de contenu
        if (method_exists($this->contentable, 'getUrlAttribute')) {
            return $this->contentable->url;
        }

        // URLs par défaut selon le type
        switch ($this->contentable_type) {
            case 'App\Models\Post':
                return route('posts.show', $this->contentable->slug ?? $this->contentable->id);
            case 'App\Models\Video':
                return route('public.videos.show', $this->contentable->slug ?? $this->contentable->id);
            case 'App\Models\Fiche':
                return route('fiches.show', $this->contentable->slug ?? $this->contentable->id);
                // Ajouter d'autres cas selon vos routes
            default:
                return null;
        }
    }

    /**
     * Scope pour les contenus actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les contenus ordonnés
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
