<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RomanSlotsSpin extends Model {
    protected $table = 'roman_slots_spins';
    protected $guarded = [];

    protected $casts = [
        'grid_matrix' => 'array',
        'winning_lines' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(RomanSlotsTransaction::class, 'spin_id');
    }
}
