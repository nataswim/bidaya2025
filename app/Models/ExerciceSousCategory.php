<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ExerciceSousCategory extends Model
{
    use HasFactory;

    protected $table = 'exercice_sous_categories';

    protected $fillable = [
    'exercice_category_id',
    'name',
    'slug',
    'description',
    'image',
    'is_active',
    'sort_order', // ← AJOUTER
];

    protected $casts = [
        'exercice_category_id' => 'integer',
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relation avec la catégorie parente
    public function category()
    {
        return $this->belongsTo(ExerciceCategory::class, 'exercice_category_id');
    }

    // Relation Many-to-Many avec exercices
    public function exercices()
    {
        return $this->belongsToMany(
            Exercice::class,
            'exercice_exercice_sous_category',
            'exercice_sous_category_id',
            'exercice_id'
        )->withTimestamps()->withPivot('ordre');
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