<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'group_name', 'image', 'meta_title',
        'meta_description', 'meta_keywords', 'order', 'status', 'created_by',
        'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}