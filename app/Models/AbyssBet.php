<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbyssBet extends Model {
    protected $table = 'abyss_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function round() {
        return $this->belongsTo(AbyssRound::class, 'round_id');
    }
}
