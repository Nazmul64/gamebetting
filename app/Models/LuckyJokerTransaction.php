<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyJokerTransaction extends Model {
    protected $table = 'lucky_joker_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(LuckyJokerSpin::class, 'spin_id');
    }
}
