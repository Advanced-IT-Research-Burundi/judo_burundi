<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu', 'image', 'titre', 'user_id', 'typepost_id',
        'date_post', 'lieu_evenement', 'date_evenement_debut',
        'date_evenement_fin', 'niveau_competition', 'resultats'
    ];

    protected $casts = [
        'date_post' => 'datetime',
        'date_evenement_debut' => 'datetime',
        'date_evenement_fin' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typePost()
    {
        return $this->belongsTo(TypePost::class, 'typepost_id');
    }

    // NOUVELLES MÉTHODES AJOUTÉES
    public function isEvent()
    {
        return !is_null($this->date_evenement_debut) || 
               !is_null($this->lieu_evenement) ||
               in_array($this->typePost->nom ?? '', ['Événement', 'Compétition']);
    }

    public function isUpcoming()
    {
        if (!$this->date_evenement_debut) {
            return false;
        }
        return $this->date_evenement_debut->isFuture();
    }

    public function scopeEvents($query)
    {
        return $query->whereNotNull('date_evenement_debut')
                    ->orWhereNotNull('lieu_evenement');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereNotNull('date_evenement_debut')
                    ->where('date_evenement_debut', '>', now());
    }
}