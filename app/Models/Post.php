<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'user_id',
        'typepost_id',
        'date_post'
    ];

    protected $casts = [
        'date_post' => 'datetime'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typepost()
    {
        return $this->belongsTo(TypePost::class);
    }

    // Accesseurs
    public function getContenuExtraitAttribute()
    {
        return strlen($this->contenu) > 100 
            ? substr($this->contenu, 0, 100) . '...' 
            : $this->contenu;
    }

    public function getDatePostFormatteeAttribute()
    {
        return $this->date_post->format('d/m/Y à H:i');
    }

    public function getDatePostHumainAttribute()
    {
        return $this->date_post->diffForHumans();
    }

    // Scopes
    public function scopeParType($query, $typeId)
    {
        return $query->where('typepost_id', $typeId);
    }

    public function scopeParAuteur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecents($query)
    {
        return $query->orderBy('date_post', 'desc');
    }

    public function scopePubliesAujourdhui($query)
    {
        return $query->whereDate('date_post', today());
    }

    public function scopePubliesCetteSemaine($query)
    {
        return $query->whereBetween('date_post', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeRecherche($query, $terme)
    {
        return $query->where('contenu', 'like', "%{$terme}%");
    }

    // Mutateurs
    public function setDatePostAttribute($value)
    {
        $this->attributes['date_post'] = $value ?: now();
    }
}