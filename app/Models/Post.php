<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'intro',
        'content',
        'type',
        'category_id',
        'category_name',
        'is_featured',
        'image',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_og_image',
        'meta_og_url',
        'hits',
        'order',
        'status',
        'moderated_by',
        'moderated_at',
        'created_by',
        'created_by_name',
        'created_by_alias',
        'updated_by',
        'deleted_by',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
