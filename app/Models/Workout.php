<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * 🇬🇧 Workout model representing a workout in the system
 * 🇫🇷 Modèle Workout représentant un workout dans le système
 * 
 * @file app/Models/Workout.php
 */
class Workout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'total',
    ];

    protected $casts = [
        'total' => 'integer',
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

        static::creating(function ($workout) {
            // 🇬🇧 Auto-generate slug / 🇫🇷 Génération automatique du slug
            if (empty($workout->slug)) {
                $workout->slug = Str::slug($workout->title);
            }
        });

        static::updating(function ($workout) {
            if ($workout->isDirty('title') && empty($workout->slug)) {
                $workout->slug = Str::slug($workout->title);
            }
        });
    }

    /**
     * 🇬🇧 Get the categories that belong to this workout
     * 🇫🇷 Obtenir les catégories qui appartiennent à ce workout
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(WorkoutCategory::class, 'workout_workout_category')
                    ->withPivot('order_number')
                    ->withTimestamps()
                    ->orderBy('workout_categories.name', 'asc');
    }

    /**
     * 🇬🇧 Scope for ordered workouts by title
     * 🇫🇷 Scope pour les workouts ordonnés par titre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('title', 'asc');
    }

    /**
     * 🇬🇧 Get excerpt from content
     * 🇫🇷 Obtenir un extrait du contenu
     */
    public function getExcerptAttribute(): string
    {
        if ($this->short_description) {
            return strip_tags($this->short_description);
        }
        
        return Str::limit(strip_tags($this->long_description), 160);
    }

    /**
     * 🇬🇧 Format total in meters
     * 🇫🇷 Formater le total en mètres
     */
    public function getFormattedTotalAttribute(): string
    {
        if ($this->total >= 1000) {
            return number_format($this->total / 1000, 2) . ' km';
        }
        return $this->total . ' m';
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