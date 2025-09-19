<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'group_name', 'description', 'image', 'status',
        'meta_title', 'meta_description', 'meta_keywords', 'created_by',
        'updated_by', 'deleted_by',
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}