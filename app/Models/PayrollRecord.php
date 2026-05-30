<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'branch_id', 'month', 'year',
        'basic_salary', 'allowances', 'bonuses', 'commissions',
        'overtime_pay', 'deductions', 'tax', 'net_salary',
        'payment_method', 'status', 'paid_at', 'reference', 'notes',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($record) {
            $record->calculateNet();
        });
    }

    protected $casts = [
        'paid_at' => 'datetime',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'commissions' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'deductions' => 'decimal:2',
        'tax' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function calculateNet()
    {
        $gross = (float)$this->basic_salary + (float)$this->allowances + (float)$this->bonuses
            + (float)$this->commissions + (float)$this->overtime_pay;
        $net = $gross - (float)$this->deductions - (float)$this->tax;
        $this->net_salary = number_format($net, 2, '.', '');
        return $this->net_salary;
    }

    public function getMonthNameAttribute()
    {
        return \Carbon\Carbon::createFromDate($this->year, $this->month, 1)->format('F Y');
    }
}
