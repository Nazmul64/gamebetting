<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class K3Transaction extends Model {
    protected $table = 'k3_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(K3Bet::class, 'bet_id');
    }
}
