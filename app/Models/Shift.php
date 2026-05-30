<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'name', 'start_time', 'end_time', 'break_minutes', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_shifts')
            ->withPivot('effective_from', 'effective_until')
            ->withTimestamps();
    }

    public function getDurationHoursAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return round($start->diffInMinutes($end) / 60, 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
