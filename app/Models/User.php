<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Champs Laravel par défaut
        'name',
        'email',
        'password',

        // Champs ajoutés par la migration update_users_table_add_profile_fields
        'username',
        'first_name',
        'last_name',
        'role_id',
        'avatar',
        'bio',
        'phone',
        'date_of_birth',
        'status',
        'last_login_at',
        'last_login_ip',
        'login_count',
        'preferences',
        'locale',
        'timezone',
    ];

    /**
     * Les attributs à cacher lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à caster automatiquement.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'date_of_birth'     => 'date',
        'last_login_at'     => 'datetime',
        'preferences'       => 'array',
    ];

    /**
     * Relation : un utilisateur appartient à un rôle.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation : un utilisateur peut avoir plusieurs posts créés.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }

    /**
     * Relation : un utilisateur peut avoir plusieurs catégories créées.
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    /**
     * Relation : un utilisateur peut avoir plusieurs tags créés.
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }
}
