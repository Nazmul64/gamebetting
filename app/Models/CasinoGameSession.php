<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoGameSession extends Model
{
    use HasFactory;

    protected $table = 'casino_game_sessions';

    protected $fillable = [
        'user_id',
        'game_key',
        'is_demo',
        'last_action_at',
    ];

    protected $casts = [
        'is_demo'        => 'boolean',
        'last_action_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
