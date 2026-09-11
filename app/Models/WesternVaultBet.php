<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WesternVaultBet extends Model {
    protected $table = 'western_vault_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function round() {
        return $this->belongsTo(WesternVaultRound::class, 'round_id');
    }

    public function transaction() {
        return $this->hasOne(WesternVaultTransaction::class, 'bet_id');
    }
}
