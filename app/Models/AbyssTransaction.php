<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbyssTransaction extends Model {
    protected $table = 'abyss_transactions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
