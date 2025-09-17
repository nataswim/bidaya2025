<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'group_name',
        'description',
        'image',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
