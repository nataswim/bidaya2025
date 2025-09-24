<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'intro', 'content', 'type', 'category_id', 'category_name',
        'is_featured', 'image', 'meta_title', 'meta_keywords', 'meta_description',
        'meta_og_image', 'meta_og_url', 'hits', 'order', 'status', 'visibility',
        'moderated_by', 'moderated_at', 'created_by', 'created_by_name', 
        'created_by_alias', 'updated_by', 'deleted_by', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'moderated_at' => 'datetime',
        'is_featured' => 'boolean',
        'hits' => 'integer',
        'order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    /**
     * Les mÃ©tadonnÃ©es (titre, intro, image) sont toujours visibles si le post est publiÃ©
     */
    public function isMetadataVisible(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }




    /**
     * VÃ©rifier si le contenu complet est visible pour l'utilisateur actuel
     */
    public function isContentVisibleTo($user = null): bool
{
    // Si le post n'est pas publiÃ©, seuls les admins/Ã©diteurs peuvent voir le contenu
    if (!$this->isMetadataVisible()) {
        return $user && ($user->hasRole('admin') || $user->hasRole('editor'));
    }
    
    // Si la visibilitÃ© est publique, tout le monde peut voir le contenu
    if ($this->visibility === 'public') {
        return true;
    }
    
    // Si la visibilitÃ© est "authenticated", vÃ©rifier le rôle de l'utilisateur
    if ($this->visibility === 'authenticated') {
        if (!$user) {
            return false; // Pas connectÃ© = pas d'accÃ¨s
        }
        
        // Les admins et Ã©diteurs peuvent tout voir
        if ($user->hasRole('admin') || $user->hasRole('editor')) {
            return true;
        }
        
        // Les visitors ne peuvent PAS voir le contenu premium
        if ($user->hasRole('visitor')) {
            return false; // ❌ VISITOR = PAS D'ACCÃ¨S AU PREMIUM
        }
        
        // Les users et rôles supÃ©rieurs peuvent voir
        return $user->hasRole('user') || ($user->role && $user->role->level >= 10);
    }
    
    return false;
}


/**
 * DÃ©terminer le message Ã afficher pour l'accÃ¨s restreint
 */
public function getAccessMessage($user = null): string
{
    if (!$user) {
        return 'Connectez-vous pour accÃ©der Ã ce contenu premium.';
    }
    
    if ($user->hasRole('visitor')) {
        return 'Votre compte doit être validÃ© par un administrateur pour accÃ©der aux contenus premium.';
    }
    
    return 'AccÃ¨s non autorisÃ© Ã ce contenu.';
}



    /**
     * Scope pour les posts avec mÃ©tadonnÃ©es visibles
     */
    public function scopeWithMetadataVisible($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }





    /**
 * Scope pour les posts visibles selon le niveau d'utilisateur
 */
public function scopeVisibleTo($query, $user = null)
{
    return $query->where(function($q) use ($user) {
        // Posts publics et publiÃ©s
        $q->where('status', 'published')
          ->whereNotNull('published_at')
          ->where('published_at', '<=', now())
          ->where('visibility', 'public');
        
        // Si utilisateur connectÃ© et NON-visitor, ajouter les posts premium
        if ($user && !$user->hasRole('visitor')) {
            $q->orWhere(function($subQ) use ($user) {
                $subQ->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->where('visibility', 'authenticated');
            });
        }
        
        // Si admin/Ã©diteur, voir tous les posts
        if ($user && ($user->hasRole('admin') || $user->hasRole('editor'))) {
            $q->orWhere(function($subQ) {
                $subQ->whereIn('status', ['draft', 'published']);
            });
        }
    });
}






    /**
     * Scope pour les posts publiÃ©s uniquement
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope pour les posts mis en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Accessor pour l'URL de l'article
     */
    public function getUrlAttribute()
    {
        return route('public.show', $this->slug);
    }

    /**
     * Accessor pour le rÃ©sumÃ© du contenu
     */
    public function getExcerptAttribute()
    {
        if ($this->intro) {
            return $this->intro;
        }
        
        return \Str::limit(strip_tags($this->content), 160);
    }

    /**
     * Accessor pour le temps de lecture estimÃ©
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // 200 mots par minute en moyenne
        
        return $readingTime;
    }

    /**
     * Mutator pour gÃ©nÃ©rer automatiquement le slug
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    /**
     * Boot method pour les Ã©vÃ©nements du modÃ¨le
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (auth()->check()) {
                $post->created_by = auth()->id();
                $post->created_by_name = auth()->user()->name;
            }
        });

        static::updating(function ($post) {
            if (auth()->check()) {
                $post->updated_by = auth()->id();
            }
        });
    }
}