<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'discipline',
        'title',
        'objective',
        'type',
        'color',
        'event_date',
        'event_time',
        'location',
        'description',
        'remarks',
        'material',
        'planned_duration',
        'planned_distance',
        // SUPPRIMER linkable_type et linkable_id si migration effectuée
        'status',
        'effort_feeling',
        'objective_achieved',
        'actual_duration',
        'actual_distance',
        'weather_conditions',
        'pain_discomfort',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
    ];

    // Relations existantes
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ========== NOUVELLES RELATIONS ==========

    /**
     * Tous les contenus liés (workouts + exercices)
     */
    public function linkables(): HasMany
    {
        return $this->hasMany(EventLinkable::class)->orderBy('order');
    }

    /**
     * Seulement les workouts liés
     */
    public function workouts()
    {
        return $this->linkables()
            ->where('linkable_type', \App\Models\Workout::class)
            ->with('linkable');
    }

    /**
     * Seulement les exercices liés
     */
    public function exercices()
    {
        return $this->linkables()
            ->where('linkable_type', \App\Models\Exercice::class)
            ->with('linkable')
            ->orderBy('order');
    }

    /**
     * Vérifier si l'événement a des contenus liés
     */
    public function hasLinkedContent(): bool
    {
        return $this->linkables()->exists();
    }

    /**
     * Obtenir le workout lié (s'il y en a un)
     */
    public function getLinkedWorkoutAttribute()
    {
        $workoutLink = $this->workouts()->first();
        return $workoutLink ? $workoutLink->linkable : null;
    }

    /**
     * Obtenir les exercices liés
     */
    public function getLinkedExercicesAttribute()
    {
        return $this->exercices()
            ->get()
            ->map(function($link) {
                return $link->linkable;
            })
            ->filter(); // Enlever les nulls
    }

    // ========== ACCESSORS EXISTANTS (garder tous) ==========
    
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'entrainement' => 'Entraînement',
            'rendez-vous' => 'Rendez-vous',
            'stage' => 'Stage',
            'competition' => 'Compétition',
            'autres' => 'Autres',
            default => 'Activité'
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'entrainement' => 'fas fa-dumbbell',
            'rendez-vous' => 'fas fa-calendar-check',
            'stage' => 'fas fa-graduation-cap',
            'competition' => 'fas fa-trophy',
            'autres' => 'fas fa-bookmark',
            default => 'fas fa-calendar'
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'entrainement' => '#007bff',
            'rendez-vous' => '#6c757d',
            'stage' => '#fd7e14',
            'competition' => '#ffc107',
            'autres' => '#6f42c1',
            default => '#007bff'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'planned' => 'Planifié',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            default => 'Inconnu'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'planned' => '<span class="badge bg-primary">📅 Planifié</span>',
            'completed' => '<span class="badge bg-success">✅ Terminé</span>',
            'cancelled' => '<span class="badge bg-secondary">❌ Annulé</span>',
            default => ''
        };
    }

    public function getObjectiveAchievedLabelAttribute(): ?string
    {
        if (!$this->objective_achieved) return null;
        
        return match($this->objective_achieved) {
            'not_achieved' => 'Non atteint',
            'achieved' => 'Atteint',
            'exceeded' => 'Dépassé',
            default => null
        };
    }

    public function getWeatherLabelAttribute(): ?string
    {
        if (!$this->weather_conditions) return null;
        
        return match($this->weather_conditions) {
            'sunny' => '☀️ Ensoleillé',
            'cloudy' => '☁️ Nuageux',
            'rainy' => '🌧️ Pluie',
            'windy' => '💨 Venteux',
            'cold' => '❄️ Froid',
            'hot' => '🔥 Chaud',
            default => null
        };
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->event_date->translatedFormat('l d F Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->event_time->format('H:i');
    }

    public function getFormattedDateTimeAttribute(): string
    {
        return $this->formatted_date . ' à ' . $this->formatted_time;
    }

    public function getIsPastAttribute(): bool
    {
        $eventDateTime = Carbon::parse($this->event_date->format('Y-m-d') . ' ' . $this->event_time->format('H:i:s'));
        return $eventDateTime->isPast();
    }

    public function getNeedsCompletionAttribute(): bool
    {
        return $this->is_past && $this->status === 'planned';
    }

    // ========== SCOPES EXISTANTS (garder tous) ==========
    
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePlanned($query)
    {
        return $query->where('status', 'planned');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'planned')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('event_time');
    }

    public function scopePast($query)
    {
        return $query->where(function($q) {
            $q->where('event_date', '<', now()->toDateString())
              ->orWhere(function($subQ) {
                  $subQ->where('event_date', '=', now()->toDateString())
                       ->whereTime('event_time', '<', now()->format('H:i:s'));
              });
        })->orderByDesc('event_date')->orderByDesc('event_time');
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('event_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->orderBy('event_date')->orderBy('event_time');
    }

    public function scopeNeedsCompletion($query)
    {
        return $query->where('status', 'planned')
            ->where(function($q) {
                $q->where('event_date', '<', now()->toDateString())
                  ->orWhere(function($subQ) {
                      $subQ->where('event_date', '=', now()->toDateString())
                           ->whereTime('event_time', '<', now()->format('H:i:s'));
                  });
            });
    }
}