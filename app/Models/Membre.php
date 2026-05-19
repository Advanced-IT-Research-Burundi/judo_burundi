<?php

namespace App\Models;

use App\Support\PublicStorageAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    protected $table = 'membres';
    protected $fillable = [
        'fullname',
        'description',
        'email',
        'telephone',
        'image',
    ];

    /** URL publique de la photo (disk public), ou null. */
    public function imageUrl(): ?string
    {
        return PublicStorageAsset::url($this->image);
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

}
