<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OlympusAuditLog extends Model
{
    use HasFactory;

    protected $table = 'olympus_audit_logs';

    protected $fillable = [
        'admin_id',
        'setting_key',
        'old_value',
        'new_value',
        'ip_address',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
