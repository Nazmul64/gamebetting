<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WesternVaultRound extends Model {
    protected $table = 'western_vault_rounds';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'ends_at' => 'datetime'
    ];

    public function bets() {
        return $this->hasMany(WesternVaultBet::class, 'round_id');
    }
}
