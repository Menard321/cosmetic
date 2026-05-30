<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $fillable = [
        'user_id',
        'beauty_event_id',
        'ticket_code',
        'status',
        'redeemed_at'
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(BeautyEvent::class, 'beauty_event_id');
    }
}
