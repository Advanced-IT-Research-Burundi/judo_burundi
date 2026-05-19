<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'image',
        'typepost_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Alias FR utilisé par plusieurs vues (accueil, blog).
     */
    public function getTitreAttribute(): string
    {
        return (string) ($this->attributes['title'] ?? '');
    }

    /**
     * Alias FR pour le corps d’article (anciennes vues utilisaient « contenu »).
     */
    public function getContenuAttribute(): string
    {
        return (string) ($this->attributes['content'] ?? '');
    }

    /**
     * Résumé court pour les cartes (calculé à partir du contenu).
     */
    public function getExtraitAttribute(): ?string
    {
        $html = $this->attributes['content'] ?? '';

        return $html !== '' ? Str::limit(strip_tags((string) $html), 200) : null;
    }

    public function typePost()
    {
        return $this->belongsTo(TypePost::class, 'typepost_id');
    }
}