<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 WorkoutCategory model representing a workout category in the system
 * 🇫🇷 Modèle WorkoutCategory représentant une catégorie de workout dans le système
 * 
 * @file app/Models/WorkoutCategory.php
 */
class WorkoutCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'workout_section_id',
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

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * 🇬🇧 Get the section that owns this category
     * 🇫🇷 Obtenir la section qui possède cette catégorie
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(WorkoutSection::class, 'workout_section_id');
    }

    /**
     * 🇬🇧 Get the workouts that belong to this category
     * 🇫🇷 Obtenir les workouts qui appartiennent à cette catégorie
     */
    public function workouts(): BelongsToMany
    {
        return $this->belongsToMany(Workout::class, 'workout_workout_category')
                    ->withPivot('order_number')
                    ->withTimestamps()
                    ->orderBy('workout_workout_category.order_number', 'asc');
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