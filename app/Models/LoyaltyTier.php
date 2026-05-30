<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTier extends Model
{
    protected $fillable = [
        'name',
        'min_points',
        'discount_percentage',
        'perks',
        'color_hex'
    ];

    protected $casts = [
        'perks' => 'array',
    ];
}
