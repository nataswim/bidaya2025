<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Exercice extends Model
{
    use HasFactory;

    protected $table = 'exercices';

    protected $fillable = [
        'titre',
        'description',
        'image',
        'niveau',
        'muscles_cibles',
        'consignes_securite',
        'video_url',
        'type_exercice',
        'is_active',
        'ordre',
        'created_by',
    ];

    protected $casts = [
        'muscles_cibles' => 'array',
        'is_active' => 'boolean',
        'ordre' => 'integer',
        'created_by' => 'integer',
    ];

    // Relations Many-to-Many avec catégories
    public function categories()
    {
        return $this->belongsToMany(
            ExerciceCategory::class,
            'exercice_exercice_category',
            'exercice_id',
            'exercice_category_id'
        )->withTimestamps()->withPivot('ordre')->orderBy('ordre');
    }

    public function sousCategories()
    {
        return $this->belongsToMany(
            ExerciceSousCategory::class,
            'exercice_exercice_sous_category',
            'exercice_id',
            'exercice_sous_category_id'
        )->withTimestamps()->withPivot('ordre')->orderBy('ordre');
    }

    // Autres relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function series()
    {
        return $this->hasMany(Serie::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('ordre')->orderBy('titre');
    }

    // Accesseurs
    public function getMusclesCiblesFormattedAttribute(): string
    {
        if (!$this->muscles_cibles || !is_array($this->muscles_cibles)) {
            return 'Non défini';
        }
        
        $muscles = array_filter($this->muscles_cibles);
        return !empty($muscles) ? implode(', ', $muscles) : 'Non défini';
    }

    public function getNiveauLabelAttribute(): string
    {
        return match($this->niveau) {
            'debutant' => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance' => 'Avancé',
            'special' => 'Spécial',
            default => 'Non défini'
        };
    }

    public function getTypeExerciceLabelAttribute(): string
    {
        return match($this->type_exercice) {
            'cardio' => 'Cardio',
            'force' => 'Force',
            'flexibilite' => 'Flexibilité',
            'equilibre' => 'Équilibre',
            default => 'Non défini'
        };
    }

    // Route key name pour utiliser le slug dans les URLs
    public function getRouteKeyName()
    {
        return 'id'; // Ou 'slug' si vous avez un champ slug
    }

    // Boot method pour définir created_by automatiquement
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($exercice) {
            if (auth()->check() && empty($exercice->created_by)) {
                $exercice->created_by = auth()->id();
            }
        });
    }
}