<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WingoBet extends Model {
    protected $table = 'wingo_bets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function period() {
        return $this->belongsTo(WingoPeriod::class, 'period_id');
    }
}
