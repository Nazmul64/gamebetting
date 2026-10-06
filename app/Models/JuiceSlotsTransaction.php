<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuiceSlotsTransaction extends Model
{
    protected $table = 'juice_slots_transactions';
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
        return $this->belongsTo(JuiceSlotsSpin::class, 'spin_id');
    }
}
