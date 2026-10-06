<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardGames21Bet extends Model {
    protected $table = 'card_games21_bets';
    protected $guarded = [];

    protected $casts = [
        'player_cards' => 'array',
        'dealer_cards' => 'array',
        'remaining_deck' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(CardGames21Transaction::class, 'bet_id');
    }
}
