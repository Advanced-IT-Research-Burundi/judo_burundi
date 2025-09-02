<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
        use HasFactory;

    protected $guarded = [''];
    protected $table = 'posts';

    protected $casts = [
        'date_post' => 'datetime',
    ];

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }

    public function typePost()
    {
        return $this->belongsTo(TypePost::class, 'typepost_id');
    }
}
