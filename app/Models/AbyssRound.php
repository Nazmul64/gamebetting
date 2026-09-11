<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbyssRound extends Model {
    protected $table = 'abyss_rounds';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'ends_at' => 'datetime'
    ];

    public function bets() {
        return $this->hasMany(AbyssBet::class, 'round_id');
    }
}
