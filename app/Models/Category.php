<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'group_name',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'order',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
