<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceReview;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year  ?? now()->year;

        $query = PerformanceReview::with('employee.branch')
            ->where('month', $month)->where('year', $year)
            ->orderByDesc('overall_score');

        if ($request->branch_id) {
            $query->whereHas('employee', fn($q) => $q->where('branch_id', $request->branch_id));
        }

        $reviews  = $query->paginate(15)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        $topPerformer = PerformanceReview::with('employee.branch')
            ->where('month', $month)->where('year', $year)
            ->orderByDesc('overall_score')->first();

        $stats = [
            'avg_score'    => $query->avg('overall_score'),
            'outstanding'  => PerformanceReview::where('month', $month)->where('year', $year)->where('rating', 'outstanding')->count(),
            'excellent'    => PerformanceReview::where('month', $month)->where('year', $year)->where('rating', 'excellent')->count(),
            'top_performer'=> $topPerformer,
        ];

        return view('admin.ems.performance.index', compact('reviews', 'branches', 'stats', 'month', 'year', 'topPerformer'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id'         => 'required|exists:employees,id',
            'month'               => 'required|integer|min:1|max:12',
            'year'                => 'required|integer',
            'sales_score'         => 'required|numeric|min:0|max:100',
            'attendance_score'    => 'required|numeric|min:0|max:100',
            'task_completion'     => 'required|numeric|min:0|max:100',
            'customer_rating'     => 'required|numeric|min:0|max:100',
            'feedback'            => 'nullable|string',
            'areas_of_improvement'=> 'nullable|string',
        ]);
        $data['reviewed_by'] = auth()->id();
        $data['top_performer'] = (($data['sales_score'] + $data['attendance_score'] + $data['task_completion'] + $data['customer_rating']) / 4) >= 85;

        PerformanceReview::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'month' => $data['month'], 'year' => $data['year']],
            $data
        );

        return back()->with('success', 'Performance review saved.');
    }
}
