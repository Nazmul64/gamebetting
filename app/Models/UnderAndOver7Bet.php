<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnderAndOver7Bet extends Model {
    protected $table = 'under_and_over7_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(UnderAndOver7Transaction::class, 'bet_id');
    }
}
