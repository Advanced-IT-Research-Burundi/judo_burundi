<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';
    protected $guarded = [''];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class);
    }
}
