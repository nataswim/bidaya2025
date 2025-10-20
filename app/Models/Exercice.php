<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'titre',
    'description',
    'image',
    'exercice_category_id',      
    'exercice_sous_category_id', 
    'niveau',
    'muscles_cibles',
    'consignes_securite',
    'video_url',
    'type_exercice',
    'is_active',
    'ordre',
    'created_by',
    'updated_by',
];

    protected $casts = [
    'muscles_cibles' => 'array',
    'is_active' => 'boolean',
    'ordre' => 'integer',
    'exercice_category_id' => 'integer',      // ← AJOUTER
    'exercice_sous_category_id' => 'integer', // ← AJOUTER
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    // Relations
    public function series()
    {
        return $this->hasMany(Serie::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
public function category()
{
    return $this->belongsTo(ExerciceCategory::class, 'exercice_category_id');
}

public function sousCategory()
{
    return $this->belongsTo(ExerciceSousCategory::class, 'exercice_sous_category_id');
}
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByNiveau($query, $niveau)
    {
        return $query->where('niveau', $niveau);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type_exercice', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('titre');
    }

    // Accessors - avec gestion des valeurs NULL
    public function getNiveauLabelAttribute(): string
    {
        if (!$this->niveau) {
            return '<span class="badge bg-secondary">Non défini</span>';
        }

        return match($this->niveau) {
            'debutant' => 'Débutant',
            'intermediaire' => 'Intermédiaire', 
            'avance' => 'Avancé',
            'special' => 'Spécial',
            default => ucfirst($this->niveau)
        };
    }

    public function getTypeExerciceLabelAttribute(): string
    {
        if (!$this->type_exercice) {
            return '<span class="badge bg-secondary">Non défini</span>';
        }

        return match($this->type_exercice) {
            'cardio' => 'Cardio',
            'force' => 'Force',
            'flexibilite' => 'Flexibilité',
            'equilibre' => 'Équilibre',
            default => ucfirst($this->type_exercice)
        };
    }

    public function getMusclesCiblesFormattedAttribute(): string
    {
        if (!$this->muscles_cibles || !is_array($this->muscles_cibles) || count($this->muscles_cibles) === 0) {
            return 'Non spécifié';
        }
        
        return collect($this->muscles_cibles)
            ->map(fn($muscle) => ucfirst($muscle))
            ->join(', ');
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($exercice) {
            if (auth()->check()) {
                $exercice->created_by = auth()->id();
            }
        });

        static::updating(function ($exercice) {
            if (auth()->check()) {
                $exercice->updated_by = auth()->id();
            }
        });
    }
}