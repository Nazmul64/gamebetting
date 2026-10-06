<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrystalSpin extends Model {
    protected $table = 'crystal_spins';
    protected $guarded = [];

    protected $casts = [
        'initial_grid' => 'array',
        'cascades' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactions() {
        return $this->hasMany(CrystalTransaction::class, 'spin_id');
    }
}
