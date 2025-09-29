<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPlan extends Pivot
{
    protected $table = 'user_plans';

    protected $fillable = [
        'user_id',
        'plan_id',
        'date_debut',
        'date_fin_prevue',
        'statut',
        'progression_pourcentage',
        'notes_utilisateur',
        'preferences',
        'assigned_by',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin_prevue' => 'date',
        'progression_pourcentage' => 'integer',
        'preferences' => 'array',
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'assigned_by' => 'integer',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Accessors
    public function getStatutLabelAttribute()
    {
        return match($this->statut) {
            'non_commence' => 'Non commencé',
            'en_cours' => 'En cours',
            'pause' => 'En pause',
            'termine' => 'Terminé',
            'abandonne' => 'Abandonné',
            default => 'Non défini'
        };
    }

    public function getStatutColorAttribute()
    {
        return match($this->statut) {
            'non_commence' => 'secondary',
            'en_cours' => 'primary',
            'pause' => 'warning',
            'termine' => 'success',
            'abandonne' => 'danger',
            default => 'secondary'
        };
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('statut', ['non_commence', 'en_cours', 'pause']);
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeTermine($query)
    {
        return $query->where('statut', 'termine');
    }
}