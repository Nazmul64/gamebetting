<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyJokerSpin extends Model {
    protected $table = 'lucky_joker_spins';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'winning_lines' => 'array',
        'has_expanding_wild' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
