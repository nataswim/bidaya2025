<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exercice_id',
        'nom',
        'repetitions',
        'duree_secondes',
        'distance_metres',
        'poids_kg',
        'repos_secondes',
        'consignes',
        'ordre',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'exercice_id' => 'integer',
        'repetitions' => 'integer',
        'duree_secondes' => 'integer',
        'distance_metres' => 'decimal:2',
        'poids_kg' => 'decimal:2',
        'repos_secondes' => 'integer',
        'ordre' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relations
    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    public function seances()
    {
        return $this->belongsToMany(Seance::class, 'seance_series')
                    ->withPivot('ordre', 'nombre_series', 'notes')
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre');
    }

    // Accessors
    public function getNomCompletAttribute()
    {
        $nom = $this->nom ?: $this->exercice->titre;
        
        $details = [];
        if ($this->repetitions) $details[] = $this->repetitions . ' rép.';
        if ($this->duree_secondes) $details[] = gmdate('i:s', $this->duree_secondes);
        if ($this->distance_metres) $details[] = $this->distance_metres . 'm';
        if ($this->poids_kg) $details[] = $this->poids_kg . 'kg';
        
        return $nom . (!empty($details) ? ' (' . implode(', ', $details) . ')' : '');
    }

    public function getReposFormateAttribute()
{
    if ($this->repos_secondes < 60) {
        return $this->repos_secondes . 's';
    }
    return gmdate('i:s', $this->repos_secondes);
}

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($serie) {
            if (auth()->check()) {
                $serie->created_by = auth()->id();
            }
        });

        static::updating(function ($serie) {
            if (auth()->check()) {
                $serie->updated_by = auth()->id();
            }
        });
    }
}