<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id', 'user_id', 'branch_id', 'full_name', 'photo', 'gender',
        'date_of_birth', 'national_id', 'phone', 'email', 'address',
        'emergency_contact_name', 'emergency_contact_phone',
        'position', 'department', 'employment_type', 'date_hired',
        'contract_start', 'contract_end', 'reporting_manager_id', 'status',
        'basic_salary', 'payment_method', 'notes',
        'bank_name', 'account_name', 'account_number', 'mobile_money_name', 'mobile_money_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_hired' => 'date',
        'contract_start' => 'date',
        'contract_end' => 'date',
        'basic_salary' => 'decimal:2',
    ];

    // Auto-generate employee_id
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($employee) {
            $lastId = static::withTrashed()->max('id') ?? 0;
            $employee->employee_id = 'EMP-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'reporting_manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'reporting_manager_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payrollRecords()
    {
        return $this->hasMany(PayrollRecord::class);
    }

    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function transfers()
    {
        return $this->hasMany(EmployeeTransfer::class);
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'employee_shifts')
            ->withPivot('effective_from', 'effective_until')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    // Helpers
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=735c00&color=fff&size=128';
    }

    public function getAttendanceRateAttribute()
    {
        $total = $this->attendances()->whereMonth('date', now()->month)->count();
        $present = $this->attendances()->whereMonth('date', now()->month)->where('status', 'present')->count();
        return $total > 0 ? round(($present / $total) * 100, 1) : 0;
    }

    public function getLatestPerformanceAttribute()
    {
        return $this->performanceReviews()->orderByDesc('year')->orderByDesc('month')->first();
    }

    public function getCurrentShiftAttribute()
    {
        return $this->shifts()
            ->wherePivot('effective_from', '<=', now())
            ->where(function ($q) {
                $q->wherePivot('effective_until', '>=', now())
                    ->orWherePivot('effective_until', null);
            })
            ->first();
    }
}
