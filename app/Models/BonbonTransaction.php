<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonbonTransaction extends Model {
    protected $table = 'bonbon_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(BonbonSpin::class, 'spin_id');
    }
}
