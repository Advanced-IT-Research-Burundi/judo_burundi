<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePost extends Model
{
    use HasFactory;

    protected $table = 'type_posts';
    protected $guarded = [''];

    public function posts()
    {
        return $this->hasMany(Post::class, 'typepost_id');
    }
}
