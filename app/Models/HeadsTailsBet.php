<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadsTailsBet extends Model {
    protected $table = 'heads_tails_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function round() {
        return $this->belongsTo(HeadsTailsRound::class, 'round_id');
    }
}
