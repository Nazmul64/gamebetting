<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmirateSpin extends Model {
    protected $table = 'emirate_spins';
    protected $guarded = [];
    protected $casts = [
        'grid_matrix' => 'array',
        'winning_lines' => 'array',
        'is_win' => 'boolean',
        'is_scatter_win' => 'boolean',
        'is_demo' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
