<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class K3Period extends Model {
    protected $table = 'k3_periods';
    protected $guarded = [];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function bets() {
        return $this->hasMany(K3Bet::class, 'period_id');
    }
}
