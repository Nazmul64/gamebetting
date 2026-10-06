<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardGames21Transaction extends Model {
    protected $table = 'card_games21_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(CardGames21Bet::class, 'bet_id');
    }
}
