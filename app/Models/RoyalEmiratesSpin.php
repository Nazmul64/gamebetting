<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoyalEmiratesSpin extends Model {
    protected $table = 'royal_emirates_spins';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'coin_values' => 'array',
        'is_win' => 'boolean',
        'triggered_hold_spin' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
