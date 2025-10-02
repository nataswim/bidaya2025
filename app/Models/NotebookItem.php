<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotebookItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'notebook_id',
        'notebookable_type',
        'notebookable_id',
        'order',
        'personal_note',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Relations
    public function notebook(): BelongsTo
    {
        return $this->belongsTo(Notebook::class);
    }

    public function notebookable(): MorphTo
    {
        return $this->morphTo();
    }

    // Helper pour obtenir le titre du contenu
    public function getContentTitleAttribute(): string
    {
        $content = $this->notebookable;
        
        if (!$content) {
            return 'Contenu supprimé';
        }

        return match($this->notebookable_type) {
            'App\Models\Post' => $content->name ?? 'Sans titre',
            'App\Models\Fiche' => $content->title ?? 'Sans titre',
            'App\Models\Exercice' => $content->titre ?? 'Sans titre',
            'App\Models\Workout' => $content->title ?? 'Sans titre',
            'App\Models\Plan' => $content->titre ?? 'Sans titre',
            'App\Models\Downloadable' => $content->title ?? 'Sans titre',
            default => 'Contenu inconnu'
        };
    }

    // Helper pour obtenir l'URL du contenu
    public function getContentUrlAttribute(): ?string
    {
        $content = $this->notebookable;
        
        if (!$content) {
            return null;
        }

        return match($this->notebookable_type) {
            'App\Models\Post' => route('public.show', $content),
            'App\Models\Fiche' => route('public.fiches.show', [$content->category, $content]),
            'App\Models\Exercice' => route('exercices.show', $content),
            'App\Models\Workout' => $content->categories->first() ? 
                route('public.workouts.show', [$content->categories->first()->section, $content->categories->first(), $content]) : null,
            'App\Models\Plan' => route('user.training.show', $content),
            'App\Models\Downloadable' => route('ebook.show', [$content->category->slug, $content->slug]),
            default => null
        };
    }
}