<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonbonSpin extends Model {
    protected $table = 'bonbon_spins';
    protected $guarded = [];
    
    protected $casts = [
        'grid_matrix' => 'array',
        'matched_symbols' => 'array',
        'is_demo' => 'boolean',
        'is_win' => 'boolean',
        'scatter_boost_enabled' => 'boolean',
        'bet_amount' => 'decimal:2',
        'win_amount' => 'decimal:2',
        'admin_profit' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
