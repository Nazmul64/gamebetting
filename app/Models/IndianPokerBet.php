<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndianPokerBet extends Model {
    protected $table = 'indian_poker_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(IndianPokerTransaction::class, 'bet_id');
    }
}
