<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxWingoPeriod extends Model {
    protected $table = 'trx_wingo_periods';
    protected $guarded = [];
    protected $casts = [
        'hash_tail_chars' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'total_real_bets' => 'float',
        'total_payout' => 'float',
        'admin_profit' => 'float',
    ];

    public function bets() {
        return $this->hasMany(TrxWingoBet::class, 'period_id');
    }
}
