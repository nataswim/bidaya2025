<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 WorkoutSection model representing a workout section in the system
 * 🇫🇷 Modèle WorkoutSection représentant une section de workout dans le système
 * 
 * @file app/Models/WorkoutSection.php
 */
class WorkoutSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'sort_order',
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

        static::creating(function ($section) {
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });

        static::updating(function ($section) {
            if ($section->isDirty('name') && empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the categories that belong to this section
     * 🇫🇷 Obtenir les catégories qui appartiennent à cette section
     */
    public function categories(): HasMany
    {
        return $this->hasMany(WorkoutCategory::class, 'workout_section_id');
    }

    /**
     * 🇬🇧 Get only active categories for this section
     * 🇫🇷 Obtenir uniquement les catégories actives pour cette section
     */
    public function activeCategories(): HasMany
    {
        return $this->categories()->where('is_active', true);
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