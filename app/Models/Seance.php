<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titre',
        'description',
        'niveau',
        'duree_estimee_minutes',
        'type_seance',
        'materiel_requis',
        'echauffement',
        'retour_calme',
        'image',
        'is_active',
        'ordre',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'duree_estimee_minutes' => 'integer',
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relations
    public function series()
    {
        return $this->belongsToMany(Serie::class, 'seance_series')
                    ->withPivot('ordre', 'nombre_series', 'notes')
                    ->withTimestamps()
                    ->orderBy('pivot_ordre');
    }

    public function cycles()
    {
        return $this->belongsToMany(Cycle::class, 'cycle_seances')
                    ->withPivot('ordre', 'jour_semaine', 'semaine_cycle', 'notes')
                    ->withTimestamps()
                    ->orderBy('pivot_ordre');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
        return $query->where('type_seance', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('titre');
    }

    // Accessors
 public function getNiveauLabelAttribute()
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

public function getTypeSeanceLabelAttribute()
{
    if (!$this->type_seance) {
        return '<span class="badge bg-secondary">Non défini</span>';
    }

    return match($this->type_seance) {
        'force' => 'Force',
        'cardio' => 'Cardio',
        'mixte' => 'Mixte',
        'recuperation' => 'Récupération',
        default => ucfirst($this->type_seance)
    };
}

    public function getDureeEstimeeFormatteeAttribute()
    {
        if (!$this->duree_estimee_minutes) return 'Non définie';
        
        $heures = intval($this->duree_estimee_minutes / 60);
        $minutes = $this->duree_estimee_minutes % 60;
        
        if ($heures > 0) {
            return $heures . 'h' . ($minutes > 0 ? ' ' . $minutes . 'min' : '');
        }
        
        return $minutes . 'min';
    }

    // Méthodes utiles
    public function getTotalExercices()
    {
        return $this->series->count();
    }

    public function getDureeEstimeeCalculee()
    {
        // Calcul basé sur les séries si pas de durée définie
        if ($this->duree_estimee_minutes) {
            return $this->duree_estimee_minutes;
        }

        $dureeTotal = 0;
        foreach ($this->series as $serie) {
            // Estimation basique : 30s par répétition + repos
            if ($serie->repetitions) {
                $dureeTotal += ($serie->repetitions * 30) + $serie->repos_secondes;
            } elseif ($serie->duree_secondes) {
                $dureeTotal += $serie->duree_secondes + $serie->repos_secondes;
            }
        }

        return round($dureeTotal / 60); // Retour en minutes
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seance) {
            if (auth()->check()) {
                $seance->created_by = auth()->id();
            }
        });

        static::updating(function ($seance) {
            if (auth()->check()) {
                $seance->updated_by = auth()->id();
            }
        });
    }
}