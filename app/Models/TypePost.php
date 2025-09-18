<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypePost extends Model
{
    use HasFactory;

    protected $table = 'type_posts';

    protected $fillable = [
        'nom',
        'description',
    ];

    // Relations
    public function posts()
    {
        return $this->hasMany(Post::class, 'typepost_id');
    }

    // Accessors
    public function getNombrePostsAttribute()
    {
        return $this->posts()->count();
    }

    // Scopes
    public function scopeWithPostsCount($query)
    {
        return $query->withCount('posts');
    }
}
