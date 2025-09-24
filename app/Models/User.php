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

    // Définir des valeurs par défaut
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
        return $this->role && $this->role->slug === $roleSlug;
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}
}