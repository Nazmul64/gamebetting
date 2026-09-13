<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'badge_text',
        'prize_text',
        'button_text',
        'button_url',
        'image',
        'bg_gradient',
        'order',
        'status',
    ];

    /**
     * Scope a query to only include active sliders ordered by position.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('order', 'asc');
    }
}
