<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrashPoint extends Model
{
    protected $fillable = ['point', 'status', 'sort_order'];

    protected function casts(): array
    {
        return [
            'point'      => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }
}
