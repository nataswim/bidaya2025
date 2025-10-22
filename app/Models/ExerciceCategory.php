<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ExerciceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'ordre',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relation Many-to-Many avec exercices
    public function exercices()
    {
        return $this->belongsToMany(
            Exercice::class,
            'exercice_exercice_category',
            'exercice_category_id',
            'exercice_id'
        )->withTimestamps()->withPivot('ordre');
    }

    // Relation avec sous-catégories
    public function sousCategories()
    {
        return $this->hasMany(ExerciceSousCategory::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
{
    return $query->orderBy('sort_order')->orderBy('name');
}

    // Mutateur pour générer le slug automatiquement
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    // Route key name pour utiliser le slug dans les URLs
    public function getRouteKeyName()
    {
        return 'slug';
    }
}