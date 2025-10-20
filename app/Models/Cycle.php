<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titre',
        'description',
        'duree_semaines',
        'objectif',
        'conseils',
        'image',
        'is_active',
        'ordre',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'duree_semaines' => 'integer',
        'is_active' => 'boolean',
        'ordre' => 'integer',
    ];

    // Relations
    public function seances()
    {
        return $this->belongsToMany(Seance::class, 'cycle_seances')
                    ->withPivot('ordre', 'jour_semaine', 'semaine_cycle', 'notes')
                    ->withTimestamps()
                    ->orderBy('pivot_ordre');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_cycles')
                    ->withPivot('ordre', 'semaine_debut', 'notes')
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

    public function scopeByObjectif($query, $objectif)
    {
        return $query->where('objectif', $objectif);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('titre');
    }

    // Accessors
    public function getObjectifLabelAttribute()
{
    if (!$this->objectif) {
        return 'Non défini';
    }

    return match($this->objectif) {
        'force' => 'Force',
        'endurance' => 'Endurance',
        'perte_poids' => 'Perte de poids',
        'prise_masse' => 'Prise de masse',
        'recuperation' => 'Récupération',
        'mixte' => 'Mixte',
        default => ucfirst($this->objectif)
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
    public function getTotalSeances()
    {
        return $this->seances->count();
    }

    public function getSeancesByWeek()
    {
        return $this->seances->groupBy('pivot.semaine_cycle');
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cycle) {
            if (auth()->check()) {
                $cycle->created_by = auth()->id();
            }
        });

        static::updating(function ($cycle) {
            if (auth()->check()) {
                $cycle->updated_by = auth()->id();
            }
        });
    }
}