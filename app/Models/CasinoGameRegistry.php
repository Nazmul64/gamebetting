<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoGameRegistry extends Model
{
    use HasFactory;

    protected $table = 'casino_game_registries';

    protected $fillable = [
        'game_key',
        'name',
        'is_active',
        'total_real_deposit_volume',
        'total_real_withdraw_volume',
        'total_real_bets',
        'total_real_payouts',
        'net_house_profit',
        'active_real_players_count',
        'health_status',
    ];

    protected $casts = [
        'is_active'                  => 'boolean',
        'total_real_deposit_volume'  => 'decimal:2',
        'total_real_withdraw_volume' => 'decimal:2',
        'total_real_bets'            => 'decimal:2',
        'total_real_payouts'         => 'decimal:2',
        'net_house_profit'           => 'decimal:2',
        'active_real_players_count'  => 'integer',
    ];

    public function sessions()
    {
        return $this->hasMany(CasinoGameSession::class, 'game_key', 'game_key');
    }
}
