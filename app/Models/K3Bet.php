<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class K3Bet extends Model {
    protected $table = 'k3_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function period() {
        return $this->belongsTo(K3Period::class, 'period_id');
    }
}
