<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * VideoCategory Model
 * 
 * @file app/Models/VideoCategory.php
 */
class VideoCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
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
        });
    }

    /**
     * Relation : Vidéos de cette catégorie
     */
    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'category_video');
    }

    /**
     * Relation : Vidéos publiées
     */
    public function publishedVideos(): BelongsToMany
    {
        return $this->videos()->where('is_published', true);
    }

    /**
     * Relation : Créateur
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope : Catégories actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope : Catégories ordonnées
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Route key pour le model binding
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}