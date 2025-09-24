<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Downloadable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'format', 'short_description', 'long_description', 'file_path',
        'file_size', 'cover_image', 'download_category_id', 'user_permission', 'download_count',
        'order', 'status', 'is_featured', 'meta_title', 'meta_description', 'meta_keywords',
        'created_by', 'created_by_name', 'updated_by'
    ];

    protected $casts = [
        'download_count' => 'integer',
        'order' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(DownloadCategory::class, 'download_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function downloadLogs()
    {
        return $this->hasMany(DownloadLog::class);
    }

    /**
     * VÃ©rifier si l'utilisateur peut tÃ©lÃ©charger ce fichier
     */
    public function canBeDownloadedBy($user = null): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        switch ($this->user_permission) {
            case 'public':
                return true;
            
            case 'visitor':
                return !$user; // Accessible uniquement aux non-connectÃ©s
            
            case 'user':
                // VÃ©rifier si l'utilisateur existe et a le bon rôle
                if (!$user) {
                    return false;
                }
                
                // VÃ©rifier que l'utilisateur a un rôle
                if (!$user->role) {
                    return false;
                }
                
                // Les admins et Ã©diteurs peuvent tout tÃ©lÃ©charger
                if ($user->hasRole('admin') || $user->hasRole('editor')) {
                    return true;
                }
                
                // Les users peuvent tÃ©lÃ©charger (pas les visitors)
                return $user->hasRole('user');
            
            default:
                return false;
        }
    }

    /**
     * Message d'accÃ¨s selon les permissions
     */
    public function getAccessMessage($user = null): string
    {
        if ($this->canBeDownloadedBy($user)) {
            return '';
        }

        switch ($this->user_permission) {
            case 'visitor':
                return $user ? 'Ce tÃ©lÃ©chargement est rÃ©servÃ© aux visiteurs non connectÃ©s.' : '';
            
            case 'user':
                if (!$user) {
                    return 'Connectez-vous pour tÃ©lÃ©charger ce fichier.';
                }
                if (!$user->role) {
                    return 'Votre compte n\'a pas de rôle assignÃ©.';
                }
                if ($user->hasRole('visitor')) {
                    return 'Votre compte doit être validÃ© pour accÃ©der Ã ce tÃ©lÃ©chargement.';
                }
                return 'AccÃ¨s non autorisÃ©.';
            
            default:
                return 'TÃ©lÃ©chargement non disponible.';
        }
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * SCOPE CORRIGÃ© : Scope pour les posts visibles selon le niveau d'utilisateur
     */
    public function scopeForPermission($query, $user = null)
    {
        return $query->where(function($q) use ($user) {
            // Toujours inclure les tÃ©lÃ©chargements publics
            $q->where('user_permission', 'public');
            
            // Si pas connectÃ©, ajouter les tÃ©lÃ©chargements "visitor"
            if (!$user) {
                $q->orWhere('user_permission', 'visitor');
            } 
            // Si connectÃ© avec un rôle
            elseif ($user->role) {
                // Si admin ou Ã©diteur, voir tout
                if ($user->hasRole('admin') || $user->hasRole('editor')) {
                    $q->orWhereIn('user_permission', ['visitor', 'user']);
                }
                // Si user validÃ©, voir les tÃ©lÃ©chargements user
                elseif ($user->hasRole('user')) {
                    $q->orWhere('user_permission', 'user');
                }
                // Les visitors ne voient pas les tÃ©lÃ©chargements "user"
            }
        });
    }

    /**
     * Accessors
     */
    public function getUrlAttribute()
    {
        if (!$this->category) {
            return '#';
        }
        return route('ebook.show', [$this->category->slug, $this->slug]);
    }

    public function getDownloadUrlAttribute()
    {
        if (!$this->category) {
            return '#';
        }
        return route('ebook.download', [$this->category->slug, $this->slug]);
    }

    public function getFormatDisplayAttribute()
    {
        $formats = [
            'pdf' => 'PDF',
            'epub' => 'EPUB',
            'mp4' => 'VidÃ©o MP4',
            'zip' => 'Archive ZIP',
            'doc' => 'Word DOC',
            'docx' => 'Word DOCX'
        ];

        return $formats[$this->format] ?? strtoupper($this->format);
    }

    /**
     * IncrÃ©menter le compteur de tÃ©lÃ©chargements
     */
    public function incrementDownloadCount($user = null, $request = null)
    {
        $this->increment('download_count');
        
        // Log du tÃ©lÃ©chargement
        DownloadLog::create([
            'downloadable_id' => $this->id,
            'user_id' => $user?->id,
            'ip_address' => $request?->ip() ?? request()->ip(),
            'user_agent' => $request?->userAgent() ?? request()->userAgent(),
            'referer' => $request?->header('referer') ?? request()->header('referer')
        ]);
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($downloadable) {
            if (auth()->check()) {
                $downloadable->created_by = auth()->id();
                $downloadable->created_by_name = auth()->user()->name;
            }
        });

        static::updating(function ($downloadable) {
            if (auth()->check()) {
                $downloadable->updated_by = auth()->id();
            }
        });
    }
}