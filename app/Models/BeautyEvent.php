<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeautyEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'capacity',
        'points_required',
        'image',
        'is_active'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }
}
