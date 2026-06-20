<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'type',
        'logo',
        'settings',
        'deposit_fields',
        'methods',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
        'deposit_fields' => 'array',
    ];
}
