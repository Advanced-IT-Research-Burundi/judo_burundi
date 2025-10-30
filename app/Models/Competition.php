<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
    protected $table = 'competitions';
    protected $guarded = [];

        protected $casts = [
        'date_competition' => 'date',
    ];

    public function clubDomicile()
    {
        return $this->belongsTo(Club::class, 'clubsdomicil_id');
    }

    public function clubAdversaire()
    {
        return $this->belongsTo(Club::class, 'clubadversaire_id');
    }

}
