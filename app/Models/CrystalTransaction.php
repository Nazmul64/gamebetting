<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrystalTransaction extends Model {
    protected $table = 'crystal_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(CrystalSpin::class, 'spin_id');
    }
}
