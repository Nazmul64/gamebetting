<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxingKingSpin extends Model {
    protected $table = 'boxing_king_spins';
    protected $guarded = [];
    protected $casts = [
        'grid_result' => 'array',
        'winning_cells' => 'array',
        'is_win' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
