<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'sender_type',
        'message',
        'is_read',
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
