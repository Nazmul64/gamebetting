<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigBassSpin extends Model {
    protected $table = 'big_bass_spins';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'fish_money_values' => 'array',
        'is_win' => 'boolean',
        'has_fisherman' => 'boolean',
        'is_buy_bonus' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
