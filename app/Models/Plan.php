<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titre',
        'description',
        'niveau',
        'duree_semaines',
        'objectif',
        'prerequis',
        'conseils_generaux',
        'image',
        'is_public',
        'is_featured',
        'is_active',
        'ordre',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'duree_semaines' => 'integer',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relations
    public function cycles()
    {
        return $this->belongsToMany(Cycle::class, 'plan_cycles')
                    ->withPivot('ordre', 'semaine_debut', 'notes')
                    ->withTimestamps()
                    ->orderBy('pivot_ordre');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plans')
                    ->withPivot('date_debut', 'date_fin_prevue', 'statut', 'progression_pourcentage', 'notes_utilisateur', 'preferences', 'assigned_by')
                    ->withTimestamps();
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

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByNiveau($query, $niveau)
    {
        return $query->where('niveau', $niveau);
    }

    public function scopeByObjectif($query, $objectif)
    {
        return $query->where('objectif', $objectif);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('titre');
    }

    public function scopeVisibleTo($query, $user = null)
    {
        return $query->where(function($q) use ($user) {
            $q->where('is_public', true)->where('is_active', true);
            
            // Si admin, voir tous les plans
            if ($user && $user->hasRole('admin')) {
                $q->orWhere('is_active', true);
            }
        });
    }

    // Accessors
    public function getNiveauLabelAttribute()
    {
        return match($this->niveau) {
            'debutant' => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance' => 'Avancé',
            'special' => 'Spécial',
            default => 'Non défini'
        };
    }

    public function getObjectifLabelAttribute()
    {
        return match($this->objectif) {
            'force' => 'Force',
            'endurance' => 'Endurance',
            'perte_poids' => 'Perte de poids',
            'prise_masse' => 'Prise de masse',
            'recuperation' => 'Récupération',
            'mixte' => 'Mixte',
            default => 'Non défini'
        };
    }

    public function getDureeSemainesFormatteeAttribute()
    {
        if (!$this->duree_semaines) return 'Non définie';
        
        if ($this->duree_semaines == 1) {
            return '1 semaine';
        }
        
        return $this->duree_semaines . ' semaines';
    }

    // Méthodes utiles
    public function getTotalCycles()
    {
        return $this->cycles->count();
    }

    public function getTotalSeances()
    {
        return $this->cycles->sum(function($cycle) {
            return $cycle->seances->count();
        });
    }

    public function isAssignedToUser($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    public function getUserAssignment($userId)
    {
        return $this->users()->where('user_id', $userId)->first();
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (auth()->check()) {
                $plan->created_by = auth()->id();
            }
        });

        static::updating(function ($plan) {
            if (auth()->check()) {
                $plan->updated_by = auth()->id();
            }
        });
    }
}