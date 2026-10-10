<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'customer_user_code',
        'amount',
        'seller_balance_before',
        'seller_balance_after',
        'customer_balance_before',
        'customer_balance_after',
        'notes',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
