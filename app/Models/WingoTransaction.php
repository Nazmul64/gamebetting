<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WingoTransaction extends Model {
    protected $table = 'wingo_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bet() {
        return $this->belongsTo(WingoBet::class);
    }
}
