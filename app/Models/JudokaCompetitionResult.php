<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JudokaCompetitionResult extends Model
{
    protected $table = 'judoka_competition_results';

    protected $fillable = [
        'competition_id',
        'joueur_id',
        'placement',
        'medal',
        'categorie_label',
        'pays_code',
    ];

    protected function casts(): array
    {
        return [
            'placement' => 'integer',
        ];
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function joueur(): BelongsTo
    {
        return $this->belongsTo(Joueur::class, 'joueur_id');
    }

    public function medalBorderClass(): string
    {
        return match ($this->medal) {
            'gold' => 'result-row-medal result-row-medal-gold',
            'silver' => 'result-row-medal result-row-medal-silver',
            'bronze' => 'result-row-medal result-row-medal-bronze',
            default => '',
        };
    }
}
