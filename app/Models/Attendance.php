<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'branch_id', 'date', 'check_in', 'check_out',
        'total_hours', 'is_late', 'overtime_hours', 'status', 'method', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'is_late' => 'boolean',
        'total_hours' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    // Auto-calculate hours when checking out
    public function calculateHours()
    {
        if ($this->check_in && $this->check_out) {
            $in = \Carbon\Carbon::parse($this->check_in);
            $out = \Carbon\Carbon::parse($this->check_out);
            $this->total_hours = round($out->diffInMinutes($in) / 60, 2);
            $this->overtime_hours = max(0, $this->total_hours - 8);
        }
    }
}
