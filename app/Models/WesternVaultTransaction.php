<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WesternVaultTransaction extends Model {
    protected $table = 'western_vault_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
