<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $guarded = [''];

    protected $casts = [
        'date_post' => 'datetime',
        'date_evenement_debut' => 'datetime',
        'date_evenement_fin' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typePost()
    {
        return $this->belongsTo(TypePost::class, 'typepost_id');
    }

    // Accessors
    public function getExtraitAttribute()
    {
        return \Str::limit(strip_tags($this->contenu), 150);
    }

    public function getDatePostFormateeAttribute()
    {
        return $this->date_post->format('d/m/Y à H:i');
    }

    public function getDureeEvenementAttribute()
    {
        if (!$this->date_evenement_debut || !$this->date_evenement_fin) {
            return null;
        }
        
        $debut = Carbon::parse($this->date_evenement_debut);
        $fin = Carbon::parse($this->date_evenement_fin);
        
        return $debut->diffInDays($fin) + 1;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('typepost_id', $typeId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date_evenement_debut', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('date_evenement_fin', '<', now());
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('contenu', 'like', "%{$search}%")
              ->orWhere('lieu_evenement', 'like', "%{$search}%");
        });
    }
}