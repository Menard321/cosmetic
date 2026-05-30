<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTransfer;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = EmployeeTransfer::with(['employee', 'fromBranch', 'toBranch', 'approvedBy'])
            ->latest()
            ->paginate(15);
        
        $employees = Employee::active()->orderBy('full_name')->get();
        $branches = Branch::active()->orderBy('name')->get();
        
        return view('admin.ems.transfers.index', compact('transfers', 'employees', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'to_branch_id'   => 'required|exists:branches,id',
            'transfer_date'  => 'required|date|after_or_equal:today',
            'reason'         => 'required|string',
        ]);

        $employee = Employee::findOrFail($data['employee_id']);
        $data['from_branch_id'] = $employee->branch_id;
        $data['status'] = 'pending';

        EmployeeTransfer::create($data);

        return back()->with('success', 'Transfer request created successfully.');
    }

    public function approve(EmployeeTransfer $transfer)
    {
        DB::transaction(function () use ($transfer) {
            $transfer->update([
                'status'      => 'completed',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Update the employee's current branch
            $transfer->employee->update([
                'branch_id' => $transfer->to_branch_id
            ]);
        });

        return back()->with('success', 'Transfer approved and executed.');
    }

    public function cancel(EmployeeTransfer $transfer)
    {
        $transfer->update(['status' => 'cancelled']);
        return back()->with('success', 'Transfer cancelled.');
    }
}
