<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'sujet',
        'message'
    ];

    // Scope pour les messages récents
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessor pour formater la date
    public function getDateEnvoiAttribute()
    {
        return $this->created_at->format('d/m/Y à H:i');
    }
}