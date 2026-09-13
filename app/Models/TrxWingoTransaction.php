<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxWingoTransaction extends Model {
    protected $table = 'trx_wingo_transactions';
    protected $guarded = [];
    protected $casts = [
        'amount' => 'float',
        'balance_before' => 'float',
        'balance_after' => 'float',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(TrxWingoBet::class, 'bet_id');
    }
}
