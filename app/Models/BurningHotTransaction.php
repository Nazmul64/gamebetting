<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurningHotTransaction extends Model {
    protected $table = 'burning_hot_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(BurningHotSpin::class, 'spin_id');
    }
}
