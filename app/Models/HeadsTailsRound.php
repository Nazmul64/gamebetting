<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadsTailsRound extends Model {
    protected $table = 'heads_tails_rounds';
    protected $guarded = [];
    protected $casts = ['ends_at' => 'datetime'];

    public function bets() {
        return $this->hasMany(HeadsTailsBet::class, 'round_id');
    }
}
