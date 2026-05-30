<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\PayrollRecord;
use App\Models\LeaveRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HRReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $branchId = $request->get('branch_id');

        $branches = Branch::active()->get();

        // 1. Payroll Distribution
        $payrollStats = PayrollRecord::where('month', $month)->where('year', $year)
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->selectRaw('SUM(basic_salary) as total_basic, SUM(bonuses) as total_bonuses, SUM(net_salary) as total_net, COUNT(*) as staff_count')
            ->first();

        // 2. Attendance Stats
        $attendanceStats = Attendance::whereMonth('date', $month)->whereYear('date', $year)
            ->whereHas('employee', fn($q) => $branchId ? $q->where('branch_id', $branchId) : $q)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // 3. Leave Distribution
        $leaveStats = LeaveRequest::whereMonth('start_date', $month)->whereYear('start_date', $year)
            ->when($branchId, fn($q) => $q->whereHas('employee', fn($e) => $e->where('branch_id', $branchId)))
            ->selectRaw('leave_type, COUNT(*) as count, SUM(total_days) as total_days')
            ->groupBy('leave_type')
            ->get();

        // 4. Branch Comparisons
        $branchComparisons = Employee::select('branch_id', DB::raw('COUNT(*) as total_staff'))
            ->groupBy('branch_id')
            ->with('branch')
            ->get();

        return view('admin.ems.reports.index', compact(
            'payrollStats', 'attendanceStats', 'leaveStats', 'branchComparisons',
            'branches', 'month', 'year', 'branchId'
        ));
    }
}
