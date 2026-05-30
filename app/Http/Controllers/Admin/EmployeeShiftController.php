<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeShiftController extends Controller
{
    public function index()
    {
        $assignments = DB::table('employee_shifts')
            ->join('employees', 'employee_shifts.employee_id', '=', 'employees.id')
            ->join('shifts', 'employee_shifts.shift_id', '=', 'shifts.id')
            ->select('employee_shifts.*', 'employees.full_name', 'shifts.name as shift_name', 'shifts.start_time', 'shifts.end_time')
            ->orderByDesc('employee_shifts.effective_from')
            ->paginate(20);

        $employees = Employee::active()->orderBy('full_name')->get();
        $shifts = Shift::active()->orderBy('name')->get();

        return view('admin.ems.shifts.assignment', compact('assignments', 'employees', 'shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'shift_id'       => 'required|exists:shifts,id',
            'effective_from' => 'required|date',
            'effective_until'=> 'nullable|date|after_or_equal:effective_from',
        ]);

        DB::table('employee_shifts')->insert([
            'employee_id'    => $request->employee_id,
            'shift_id'       => $request->shift_id,
            'effective_from' => $request->effective_from,
            'effective_until'=> $request->effective_until,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return back()->with('success', 'Shift assigned successfully.');
    }

    public function destroy($id)
    {
        DB::table('employee_shifts')->where('id', $id)->delete();
        return back()->with('success', 'Shift assignment removed.');
    }
}
