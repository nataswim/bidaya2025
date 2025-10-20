<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciceCategory extends Model
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
    ];

    // Relations
    public function sousCategories()
    {
        return $this->hasMany(ExerciceSousCategory::class, 'exercice_category_id');
    }

    public function exercices()
    {
        return $this->hasMany(Exercice::class, 'exercice_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getExercicesCountAttribute()
    {
        return $this->exercices()->count();
    }

    public function getSousCategoriesCountAttribute()
    {
        return $this->sousCategories()->count();
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (auth()->check()) {
                $category->created_by = auth()->id();
            }
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (auth()->check()) {
                $category->updated_by = auth()->id();
            }
            if (empty($category->slug)) {
                $category->slug = \Str::slug($category->name);
            }
        });

        static::deleting(function ($category) {
            if (auth()->check()) {
                $category->deleted_by = auth()->id();
                $category->save();
            }
        });
    }
}