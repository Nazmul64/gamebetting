<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndianPokerTransaction extends Model {
    protected $table = 'indian_poker_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(IndianPokerBet::class, 'bet_id');
    }
}
