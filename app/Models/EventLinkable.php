<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EventLinkable extends Model
{
    protected $fillable = [
        'event_id',
        'linkable_type',
        'linkable_id',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Relation avec l'événement
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relation polymorphique avec le contenu lié
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Obtenir le titre du contenu lié
     */
    public function getContentTitleAttribute(): string
    {
        $content = $this->linkable;
        
        if (!$content) {
            return 'Contenu supprimé';
        }

        return match($this->linkable_type) {
            'App\Models\Workout' => $content->title ?? 'Sans titre',
            'App\Models\Exercice' => $content->titre ?? 'Sans titre',
            default => 'Contenu inconnu'
        };
    }

    /**
     * Obtenir l'URL du contenu lié
     */
    public function getContentUrlAttribute(): ?string
    {
        $content = $this->linkable;
        
        if (!$content) {
            return null;
        }

        return match($this->linkable_type) {
            'App\Models\Workout' => $content->categories->first() ? 
                route('public.workouts.show', [
                    $content->categories->first()->section->slug ?? 'general',
                    $content->categories->first()->slug ?? 'default',
                    $content->slug
                ]) : null,
            'App\Models\Exercice' => route('exercices.show', $content->id),
            default => null
        };
    }

    /**
     * Obtenir le type de contenu formaté
     */
    public function getContentTypeAttribute(): string
    {
        return match($this->linkable_type) {
            'App\Models\Workout' => 'Séance',
            'App\Models\Exercice' => 'Exercice',
            default => 'Contenu'
        };
    }
}