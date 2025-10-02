<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content_type',
        'color',
        'is_favorite',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(NotebookItem::class)->orderBy('order');
    }

    // Accessors
    public function getContentTypeLabelAttribute(): string
    {
        return match($this->content_type) {
            'posts' => 'Articles',
            'fiches' => 'Fiches Pratiques',
            'exercices' => 'Exercices',
            'workouts' => 'Séances d\'Entraînement',
            'plans' => 'Plans d\'Entraînement',
            'downloadables' => 'Documents',
            default => 'Contenus'
        };
    }

    public function getContentTypeIconAttribute(): string
    {
        return match($this->content_type) {
            'posts' => 'fas fa-newspaper',
            'fiches' => 'fas fa-file-alt',
            'exercices' => 'fas fa-running',
            'workouts' => 'fas fa-heartbeat',
            'plans' => 'fas fa-dumbbell',
            'downloadables' => 'fas fa-book',
            default => 'fas fa-folder'
        };
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByContentType($query, $type)
    {
        return $query->where('content_type', $type);
    }

    public function scopeFavorite($query)
    {
        return $query->where('is_favorite', true);
    }
}