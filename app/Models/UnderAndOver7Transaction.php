<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnderAndOver7Transaction extends Model {
    protected $table = 'under_and_over7_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(UnderAndOver7Bet::class, 'bet_id');
    }
}
