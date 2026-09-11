<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FortuneGemsTransaction extends Model {
    protected $table = 'fortune_gems_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(FortuneGemsSpin::class, 'spin_id');
    }
}
