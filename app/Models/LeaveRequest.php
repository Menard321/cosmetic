<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'branch_id', 'leave_type', 'start_date', 'end_date',
        'total_days', 'reason', 'supporting_document', 'status',
        'approved_by', 'rejection_reason', 'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => ['label' => 'Pending', 'color' => 'yellow'],
            'manager_approved' => ['label' => 'Manager Approved', 'color' => 'blue'],
            'hr_approved' => ['label' => 'HR Approved', 'color' => 'indigo'],
            'approved' => ['label' => 'Approved', 'color' => 'green'],
            'rejected' => ['label' => 'Rejected', 'color' => 'red'],
            default => ['label' => 'Unknown', 'color' => 'gray'],
        };
    }
}
