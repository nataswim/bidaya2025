<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name',
        'role_id', 'avatar', 'bio', 'phone', 'date_of_birth', 'status',
        'last_login_at', 'last_login_ip', 'login_count', 'preferences',
        'locale', 'timezone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'last_login_at' => 'datetime',
        'preferences' => 'array',
    ];

    // Definir des valeurs par defaut
    protected $attributes = [
        'status' => 'active',
        'locale' => 'fr',
        'timezone' => 'Europe/Paris',
        'login_count' => 0,
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

    public function hasRole($roleSlug): bool
{
    // Verification de securite
    if (!$this->role) {
        return false;
    }
    
    return $this->role->slug === $roleSlug;
}

    public function payments()
{
    return $this->hasMany(Payment::class);
}
// Ajoutez ces relations à votre modèle User existant

public function plans()
{
    return $this->belongsToMany(Plan::class, 'user_plans')
                ->withPivot('date_debut', 'date_fin_prevue', 'statut', 'progression_pourcentage', 'notes_utilisateur', 'preferences', 'assigned_by')
                ->withTimestamps()
                ->using(UserPlan::class);
}

public function plansAssignes()
{
    return $this->hasMany(UserPlan::class, 'assigned_by');
}

public function exercicesCreated()
{
    return $this->hasMany(Exercice::class, 'created_by');
}

public function seriesCreated()
{
    return $this->hasMany(Serie::class, 'created_by');
}

public function seancesCreated()
{
    return $this->hasMany(Seance::class, 'created_by');
}

public function cyclesCreated()
{
    return $this->hasMany(Cycle::class, 'created_by');
}

public function plansCreated()
{
    return $this->hasMany(Plan::class, 'created_by');
}

// Méthodes utiles pour l'entraînement
public function hasActivePlan(): bool
{
    return $this->plans()->wherePivot('statut', 'en_cours')->exists();
}

public function getCurrentPlan()
{
    return $this->plans()->wherePivot('statut', 'en_cours')->first();
}

public function canAccessTraining(): bool
{
    return $this->hasRole('user') || $this->hasRole('editor') || $this->hasRole('admin');
}
public function notebooks()
{
    return $this->hasMany(Notebook::class);
}
}