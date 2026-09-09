<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OlympusRound extends Model
{
    use HasFactory;

    protected $table = 'olympus_rounds';

    protected $fillable = [
        'round_id',
        'user_id',
        'session_id',
        'mode',
        'bet_amount',
        'total_deducted',
        'is_double_chance',
        'is_buy_feature',
        'grid_symbols',
        'winning_shapes',
        'scatter_count',
        'triggered_free_spins',
        'multiplier_symbols',
        'total_multiplier',
        'base_win',
        'final_win',
        'net_profit',
        'balance_before',
        'balance_after',
        'idempotency_key',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'bet_amount'           => 'float',
        'total_deducted'       => 'float',
        'is_double_chance'     => 'boolean',
        'is_buy_feature'       => 'boolean',
        'grid_symbols'         => 'array',
        'winning_shapes'       => 'array',
        'scatter_count'        => 'integer',
        'triggered_free_spins' => 'boolean',
        'multiplier_symbols'   => 'array',
        'total_multiplier'     => 'integer',
        'base_win'             => 'float',
        'final_win'            => 'float',
        'net_profit'           => 'float',
        'balance_before'       => 'float',
        'balance_after'        => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
