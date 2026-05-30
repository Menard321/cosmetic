<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCampaign extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'multiplier',
        'starts_at',
        'ends_at',
        'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }
}
