<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'from_branch_id', 'to_branch_id',
        'transfer_date', 'reason', 'status', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fromBranch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'to_branch_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}
