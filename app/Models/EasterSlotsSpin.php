<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EasterSlotsSpin extends Model
{
    protected $table = 'easter_slots_spins';
    protected $guarded = [];

    protected $casts = [
        'grid_matrix' => 'array',
        'winning_lines' => 'array',
        'bet_amount' => 'float',
        'win_amount' => 'float',
        'multiplier' => 'float',
        'is_demo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
