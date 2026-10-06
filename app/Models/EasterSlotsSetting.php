<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EasterSlotsSetting extends Model
{
    protected $table = 'easter_slots_settings';
    protected $guarded = [];

    protected $casts = [
        'custom_paytable' => 'array',
        'is_active' => 'boolean',
        'house_profit_percentage' => 'float',
        'rtp_percentage' => 'float',
        'win_chance_percentage' => 'float',
        'min_bet' => 'float',
        'max_bet' => 'float',
        'max_payout_per_spin' => 'float',
    ];
}
