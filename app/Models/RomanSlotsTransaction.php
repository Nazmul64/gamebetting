<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RomanSlotsTransaction extends Model {
    protected $table = 'roman_slots_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spin() {
        return $this->belongsTo(RomanSlotsSpin::class, 'spin_id');
    }
}
