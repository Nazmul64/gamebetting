<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FortuneGemsSpin extends Model {
    protected $table = 'fortune_gems_spins';
    protected $guarded = [];
    
    protected $casts = [
        'grid_matrix' => 'array',
        'is_demo' => 'boolean',
        'is_win' => 'boolean',
        'triggered_wheel' => 'boolean',
        'bet_amount' => 'decimal:2',
        'win_amount' => 'decimal:2',
        'admin_profit' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
