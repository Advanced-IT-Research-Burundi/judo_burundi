<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'titre',
        'description',
        'image',
        'alt_text',
        'ordre',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_prise' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scopes pour des requêtes courantes
     */
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('created_at', 'desc');
    }

    public function scopeByCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    /**
     * Accesseurs
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getImageFullPathAttribute()
    {
        return $this->image ? storage_path('app/public/' . $this->image) : null;
    }

    public function getFormattedDatePriseAttribute()
    {
        return $this->date_prise ? $this->date_prise->format('d/m/Y') : null;
    }

    /**
     * Méthodes utilitaires
     */
    public function isActif()
    {
        return $this->statut === 'actif';
    }

    public function hasImage()
    {
        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }

    public function getImageSize()
    {
        if ($this->hasImage()) {
            $path = storage_path('app/public/' . $this->image);
            return filesize($path);
        }
        return 0;
    }

    public function getImageDimensions()
    {
        if ($this->hasImage()) {
            $path = storage_path('app/public/' . $this->image);
            $imageInfo = getimagesize($path);
            return [
                'width' => $imageInfo[0] ?? 0,
                'height' => $imageInfo[1] ?? 0,
            ];
        }
        return ['width' => 0, 'height' => 0];
    }

    /**
     * Boot method pour gérer l'ordre automatique
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ordre)) {
                $model->ordre = static::max('ordre') + 1;
            }
        });

        static::deleting(function ($model) {
            // Supprimer le fichier image lors de la suppression du modèle
            if ($model->image && Storage::disk('public')->exists($model->image)) {
                Storage::disk('public')->delete($model->image);
            }
        });
    }

    /**
     * Catégories prédéfinies
     */
    public static function getCategories()
    {
        return [
            'competition' => 'Compétition',
            'entrainement' => 'Entraînement',
            'evenement' => 'Événement',
            'technique' => 'Technique',
            'groupe' => 'Photo de groupe',
            'infrastructure' => 'Infrastructure',
            'autre' => 'Autre',
        ];
    }

    /**
     * Statuts disponibles
     */
    public static function getStatuts()
    {
        return [
            'actif' => 'Actif',
            'inactif' => 'Inactif',
        ];
    }
}