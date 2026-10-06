<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurningHotSpin extends Model {
    protected $table = 'burning_hot_spins';
    protected $guarded = [];

    protected $casts = [
        'grid_matrix' => 'array',
        'winning_lines' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(BurningHotTransaction::class, 'spin_id');
    }
}
