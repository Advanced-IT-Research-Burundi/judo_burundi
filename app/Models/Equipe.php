<?php

namespace App\Models;

use App\Support\PublicStorageAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;
    protected $table = 'equipes';
    protected $fillable = ['fullname', 'poste', 'photo'];

    /** URL publique de la photo (disk public), ou null. */
    public function photoUrl(): ?string
    {
        return PublicStorageAsset::url($this->photo);
    }
}
