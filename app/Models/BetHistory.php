<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetHistory extends Model
{
    protected $table = 'bet_histories';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'result_data' => 'array',
            'bet_amount' => 'float',
            'multiplier' => 'float',
            'payout' => 'float',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
