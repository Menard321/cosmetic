<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee.branch')->latest();
        if ($request->status)     $query->where('status', $request->status);
        if ($request->leave_type) $query->where('leave_type', $request->leave_type);
        if ($request->branch_id)  $query->whereHas('employee', fn($q) => $q->where('branch_id', $request->branch_id));

        $requests = $query->paginate(15)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        $stats = [
            'pending'  => LeaveRequest::where('status', 'pending')->count(),
            'approved' => LeaveRequest::where('status', 'approved')->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
            'this_month' => LeaveRequest::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.ems.leaves.index', compact('requests', 'branches', 'stats'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Update employee status if currently pending
        if ($leaveRequest->start_date->isToday() || $leaveRequest->start_date->isPast()) {
            $leaveRequest->employee->update(['status' => 'on_leave']);
        }

        return back()->with('success', 'Leave approved.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        $leaveRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id(),
        ]);
        return back()->with('success', 'Leave rejected.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type'  => 'required|in:annual,sick,maternity,emergency,unpaid,other',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'reason'      => 'required|string',
        ]);
        $data['total_days'] = \Carbon\Carbon::parse($data['start_date'])->diffInDays($data['end_date']) + 1;
        LeaveRequest::create($data);
        return back()->with('success', 'Leave request created.');
    }
}
