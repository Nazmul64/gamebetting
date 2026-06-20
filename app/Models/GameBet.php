<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameBet extends Model
{
    protected $fillable = [
        'user_id',
        'round_id',
        'bet_amount',
        'cashout_odds',
        'crash_point',
        'winnings',
        'result',
    ];

    protected function casts(): array
    {
        return [
            'bet_amount'   => 'float',
            'cashout_odds' => 'float',
            'crash_point'  => 'float',
            'winnings'     => 'float',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
