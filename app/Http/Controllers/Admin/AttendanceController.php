<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date   = $request->date ? \Carbon\Carbon::parse($request->date) : now();
        $query  = Attendance::with('employee.branch')->whereDate('date', $date);

        if ($request->branch_id) {
            $query->whereHas('employee', fn($q) => $q->where('branch_id', $request->branch_id));
        }
        if ($request->status) $query->where('status', $request->status);

        $records  = $query->paginate(20)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        $todayStats = [
            'present'  => Attendance::whereDate('date', $date)->where('status', 'present')->count(),
            'absent'   => Attendance::whereDate('date', $date)->where('status', 'absent')->count(),
            'late'     => Attendance::whereDate('date', $date)->where('is_late', true)->count(),
            'on_leave' => Attendance::whereDate('date', $date)->where('status', 'on_leave')->count(),
        ];

        return view('admin.ems.attendance.index', compact('records', 'branches', 'date', 'todayStats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'check_in'    => 'nullable|date_format:H:i',
            'check_out'   => 'nullable|date_format:H:i',
            'status'      => 'required|in:present,absent,half_day,on_leave,holiday,weekend',
            'method'      => 'required|in:manual,qr_code,fingerprint,facial',
            'notes'       => 'nullable|string',
        ]);

        $attendance = Attendance::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'date' => $data['date']],
            $data
        );

        if ($attendance->check_in && $attendance->check_out) {
            $attendance->calculateHours();
            $attendance->save();
        }

        return back()->with('success', 'Attendance recorded.');
    }

    public function markPresent(Request $request)
    {
        $request->validate(['employee_ids' => 'required|array', 'date' => 'required|date']);
        foreach ($request->employee_ids as $id) {
            Attendance::updateOrCreate(
                ['employee_id' => $id, 'date' => $request->date],
                ['status' => 'present', 'check_in' => '08:00', 'method' => 'manual']
            );
        }
        return back()->with('success', 'Bulk attendance marked.');
    }
}
