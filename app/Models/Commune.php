<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes';
    protected $guarded = [''];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
