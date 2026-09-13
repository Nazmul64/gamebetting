<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxWingoBet extends Model {
    protected $table = 'trx_wingo_bets';
    protected $guarded = [];
    protected $casts = [
        'unit_amount' => 'float',
        'total_amount' => 'float',
        'win_amount' => 'float',
        'is_demo' => 'boolean',
        'is_bot' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function period() {
        return $this->belongsTo(TrxWingoPeriod::class, 'period_id');
    }
}
