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
        'meta_og_image', 'meta_og_url', 'hits', 'order', 'status', 'moderated_by',
        'moderated_at', 'created_by', 'created_by_name', 'created_by_alias',
        'updated_by', 'deleted_by', 'published_at',
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
}