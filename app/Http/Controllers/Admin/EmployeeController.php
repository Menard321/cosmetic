<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\PayrollRecord;
use App\Models\PerformanceReview;
use App\Models\EmployeeTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    // EMS Dashboard
    public function dashboard()
    {
        $stats = [
            'total'          => Employee::count(),
            'active'         => Employee::where('status', 'active')->count(),
            'inactive'       => Employee::whereIn('status', ['inactive', 'suspended', 'terminated'])->count(),
            'new_this_month' => Employee::whereMonth('date_hired', now()->month)->whereYear('date_hired', now()->year)->count(),
            'on_leave'       => Employee::where('status', 'on_leave')->count(),
            'present_today'  => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'absent_today'   => Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
            'total_payroll'  => PayrollRecord::where('month', now()->month)->where('year', now()->year)->sum('net_salary'),
            'avg_performance'=> PerformanceReview::where('month', now()->month)->where('year', now()->year)->avg('overall_score'),
        ];

        $byBranch       = Branch::withCount('employees')->get();
        $topPerformers  = PerformanceReview::with('employee.branch')
            ->where('month', now()->month)->where('year', now()->year)
            ->orderByDesc('overall_score')->take(5)->get();
        $recentEmployees = Employee::with('branch')->latest()->take(8)->get();
        $pendingLeaves  = LeaveRequest::with('employee.branch')->where('status', 'pending')->latest()->take(5)->get();
        $recentTransfers = EmployeeTransfer::with(['employee', 'fromBranch', 'toBranch'])->latest()->take(5)->get();

        return view('admin.ems.dashboard', compact(
            'stats', 'byBranch', 'topPerformers', 'recentEmployees', 'pendingLeaves', 'recentTransfers'
        ));
    }

    // Employee Directory
    public function index(Request $request)
    {
        $query = Employee::with('branch')->latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('employee_id', 'like', "%{$request->search}%")
                  ->orWhere('position', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        if ($request->branch_id) $query->where('branch_id', $request->branch_id);
        if ($request->status) $query->where('status', $request->status);
        if ($request->department) $query->where('department', $request->department);
        if ($request->employment_type) $query->where('employment_type', $request->employment_type);

        $employees  = $query->paginate(15)->withQueryString();
        $branches   = Branch::orderBy('name')->get();
        $departments = Employee::select('department')->distinct()->whereNotNull('department')->pluck('department');

        return view('admin.ems.employees.index', compact('employees', 'branches', 'departments'));
    }

    public function create()
    {
        $branches  = Branch::orderBy('name')->get();
        $managers  = Employee::where('status', 'active')->orderBy('full_name')->get();
        return view('admin.ems.employees.create', compact('branches', 'managers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name'             => 'required|string|max:255',
            'gender'                => 'required|in:male,female,other',
            'date_of_birth'         => 'nullable|date',
            'national_id'           => 'nullable|string|max:30',
            'phone'                 => 'required|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'position'              => 'required|string|max:255',
            'department'            => 'nullable|string|max:100',
            'branch_id'             => 'nullable|exists:branches,id',
            'employment_type'       => 'required|in:full_time,part_time,contract,internship',
            'date_hired'            => 'required|date',
            'contract_start'        => 'nullable|date',
            'contract_end'          => 'nullable|date',
            'reporting_manager_id'  => 'nullable|exists:employees,id',
            'status'                => 'required|in:active,inactive,suspended,terminated,on_leave',
            'basic_salary'          => 'required|numeric|min:0',
            'payment_method'        => 'required|in:mobile_money,bank,cash',
            'notes'                 => 'nullable|string',
            'photo'                 => 'nullable|image|max:2048',
            'bank_name'             => 'nullable|string|max:255',
            'account_name'          => 'nullable|string|max:255',
            'account_number'        => 'nullable|string|max:255',
            'mobile_money_name'     => 'nullable|string|max:255',
            'mobile_money_number'   => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        Employee::create($data);

        return redirect()->route('admin.ems.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['branch', 'manager', 'attendances' => fn($q) => $q->latest()->take(30),
            'leaveRequests' => fn($q) => $q->latest()->take(5),
            'payrollRecords' => fn($q) => $q->orderByDesc('year')->orderByDesc('month')->take(6),
            'performanceReviews' => fn($q) => $q->orderByDesc('year')->orderByDesc('month')->take(3),
        ]);

        $attendanceRate = $employee->attendance_rate;
        $latestPerformance = $employee->latest_performance;

        return view('admin.ems.employees.show', compact('employee', 'attendanceRate', 'latestPerformance'));
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::orderBy('name')->get();
        $managers = Employee::where('status', 'active')->where('id', '!=', $employee->id)->orderBy('full_name')->get();
        return view('admin.ems.employees.edit', compact('employee', 'branches', 'managers'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'full_name'             => 'required|string|max:255',
            'gender'                => 'required|in:male,female,other',
            'date_of_birth'         => 'nullable|date',
            'national_id'           => 'nullable|string|max:30',
            'phone'                 => 'required|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'position'              => 'required|string|max:255',
            'department'            => 'nullable|string|max:100',
            'branch_id'             => 'nullable|exists:branches,id',
            'employment_type'       => 'required|in:full_time,part_time,contract,internship',
            'date_hired'            => 'required|date',
            'contract_start'        => 'nullable|date',
            'contract_end'          => 'nullable|date',
            'reporting_manager_id'  => 'nullable|exists:employees,id',
            'status'                => 'required|in:active,inactive,suspended,terminated,on_leave',
            'basic_salary'          => 'required|numeric|min:0',
            'payment_method'        => 'required|in:mobile_money,bank,cash',
            'notes'                 => 'nullable|string',
            'photo'                 => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) Storage::disk('public')->delete($employee->photo);
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($data);
        return redirect()->route('admin.ems.employees.show', $employee)->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.ems.employees.index')->with('success', 'Employee removed.');
    }
}
