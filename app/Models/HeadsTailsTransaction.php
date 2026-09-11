<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadsTailsTransaction extends Model {
    protected $table = 'heads_tails_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(HeadsTailsBet::class, 'bet_id');
    }
}
