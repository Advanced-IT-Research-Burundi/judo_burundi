<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description'
    ];

    // Relation avec les posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'typepost_id');
    }

    // Scope pour recherche
    public function scopeSearch($query, $search)
    {
        return $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }

    // Accesseur pour le nombre de posts
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    // Accesseur pour le slug
    public function getSlugAttribute()
    {
        return Str::slug($this->nom);
    }
}

