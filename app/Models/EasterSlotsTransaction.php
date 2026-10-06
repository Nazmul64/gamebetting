<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EasterSlotsTransaction extends Model
{
    protected $table = 'easter_slots_transactions';
    protected $guarded = [];

    protected $casts = [
        'amount' => 'float',
        'balance_before' => 'float',
        'balance_after' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spin()
    {
        return $this->belongsTo(EasterSlotsSpin::class, 'spin_id');
    }
}
