<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DownloadCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'icon', 'order', 'status',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function downloadables()
    {
        return $this->hasMany(Downloadable::class);
    }

    public function activeDownloadables()
    {
        return $this->hasMany(Downloadable::class)->where('status', 'active');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope pour les catÃ©gories actives
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Accessor pour l'URL de la catÃ©gorie
     */
    public function getUrlAttribute()
    {
        return route('ebook.category', $this->slug);
    }

    /**
     * Boot method pour les Ã©vÃ©nements du modÃ¨le
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (auth()->check()) {
                $category->created_by = auth()->id();
            }
        });

        static::updating(function ($category) {
            if (auth()->check()) {
                $category->updated_by = auth()->id();
            }
        });
    }
}