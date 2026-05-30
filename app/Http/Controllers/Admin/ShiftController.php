<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Branch;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::with('branch')->orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        return view('admin.ems.shifts.index', compact('shifts', 'branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'branch_id'     => 'nullable|exists:branches,id',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i',
            'break_minutes' => 'required|integer|min:0',
            'is_active'     => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        Shift::create($data);

        return back()->with('success', 'Shift created successfully.');
    }

    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'branch_id'     => 'nullable|exists:branches,id',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i',
            'break_minutes' => 'required|integer|min:0',
            'is_active'     => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $shift->update($data);

        return back()->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return back()->with('success', 'Shift deleted.');
    }
}
