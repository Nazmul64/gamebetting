<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;

    protected $table = 'kyc_verifications';

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'full_name',
        'dob',
        'front_image',
        'back_image',
        'status',
        'rejection_reason',
        'admin_note',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
    ];

    /**
     * Get the user that owns the KYC verification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Document type human readable label (Bengali & English)
     */
    public function getDocumentTypeLabelAttribute(): string
    {
        return match ($this->document_type) {
            'nid' => 'জাতীয় পরিচয়পত্র (NID)',
            'passport' => 'পাসপোর্ট (Passport)',
            'birth_certificate' => 'জন্ম নিবন্ধন (Birth Certificate)',
            default => strtoupper($this->document_type ?? 'N/A'),
        };
    }

    /**
     * Status human readable label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'verified' => 'ভেরিফাইড (Verified)',
            'pending' => 'পেন্ডিং (Pending)',
            'rejected' => 'বাতিল / রিজেক্ট (Rejected)',
            default => 'আনভেরিফাইড (Unverified)',
        };
    }
}
