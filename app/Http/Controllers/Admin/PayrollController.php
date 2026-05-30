<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollRecord;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year  ?? now()->year;

        $query = PayrollRecord::with('employee.branch')
            ->where('month', $month)->where('year', $year);

        if ($request->branch_id) {
            $query->whereHas('employee', fn($q) => $q->where('branch_id', $request->branch_id));
        }
        if ($request->status) $query->where('status', $request->status);

        $records  = $query->paginate(15)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        $stats = [
            'total_payroll'  => $query->sum('net_salary'),
            'paid_count'     => PayrollRecord::where('month', $month)->where('year', $year)->where('status', 'paid')->count(),
            'pending_count'  => PayrollRecord::where('month', $month)->where('year', $year)->where('status', 'pending')->count(),
            'total_employees'=> Employee::where('status', 'active')->count(),
        ];

        return view('admin.ems.payroll.index', compact('records', 'branches', 'stats', 'month', 'year'));
    }

    public function generatePayroll(Request $request)
    {
        $request->validate(['month' => 'required|integer|min:1|max:12', 'year' => 'required|integer']);
        
        $employees = Employee::where('status', 'active')->get();
        $created = 0;

        foreach ($employees as $emp) {
            $existing = PayrollRecord::where('employee_id', $emp->id)
                ->where('month', $request->month)->where('year', $request->year)->first();

            if (!$existing) {
                $record = PayrollRecord::create([
                    'employee_id'    => $emp->id,
                    'branch_id'      => $emp->branch_id,
                    'month'          => $request->month,
                    'year'           => $request->year,
                    'basic_salary'   => $emp->basic_salary,
                    'payment_method' => $emp->payment_method,
                    'net_salary'     => $emp->basic_salary,
                    'status'         => 'pending',
                ]);
                $created++;
            }
        }

        return back()->with('success', "Generated payroll for {$created} employees.");
    }

    public function markPaid(PayrollRecord $payrollRecord)
    {
        $payrollRecord->update(['status' => 'paid', 'paid_at' => now()]);
        return back()->with('success', 'Payment marked as paid.');
    }

    public function bulkMarkPaid(Request $request)
    {
        $request->validate(['record_ids' => 'required|array']);
        PayrollRecord::whereIn('id', $request->record_ids)->update(['status' => 'paid', 'paid_at' => now()]);
        return back()->with('success', 'Bulk payment processed.');
    }
}
