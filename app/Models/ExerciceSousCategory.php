<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciceSousCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'exercice_category_id',
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
        'exercice_category_id' => 'integer',
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(ExerciceCategory::class, 'exercice_category_id');
    }

    public function exercices()
    {
        return $this->hasMany(Exercice::class, 'exercice_sous_category_id');
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

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('exercice_category_id', $categoryId);
    }

    // Accessors
    public function getExercicesCountAttribute()
    {
        return $this->exercices()->count();
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sousCategory) {
            if (auth()->check()) {
                $sousCategory->created_by = auth()->id();
            }
            if (empty($sousCategory->slug)) {
                $sousCategory->slug = \Str::slug($sousCategory->name);
            }
        });

        static::updating(function ($sousCategory) {
            if (auth()->check()) {
                $sousCategory->updated_by = auth()->id();
            }
            if (empty($sousCategory->slug)) {
                $sousCategory->slug = \Str::slug($sousCategory->name);
            }
        });

        static::deleting(function ($sousCategory) {
            if (auth()->check()) {
                $sousCategory->deleted_by = auth()->id();
                $sousCategory->save();
            }
        });
    }
}