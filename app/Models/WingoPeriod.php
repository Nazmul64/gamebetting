<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WingoPeriod extends Model {
    protected $table = 'wingo_periods';
    protected $guarded = [];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function bets() {
        return $this->hasMany(WingoBet::class, 'period_id');
    }
}
