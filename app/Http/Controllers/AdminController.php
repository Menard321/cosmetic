<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $selectedBranchId = $request->get('branch_id');
        $branches = \App\Models\Branch::withCount('orders')->get();
        
        $query = Order::where('status', 'completed');
        $orderQuery = Order::query();
        
        if ($selectedBranchId) {
            $query->where('branch_id', $selectedBranchId);
            $orderQuery->where('branch_id', $selectedBranchId);
            $selectedBranch = $branches->find($selectedBranchId);
        } else {
            $selectedBranch = null;
        }

        $totalRevenue = $query->sum('total_amount');
        $totalOrders = $orderQuery->count();
        $totalProducts = Product::count();
        
        // Branch specific revenue for the chart
        $branchRevenue = [];
        foreach ($branches as $branch) {
            $branchRevenue[$branch->name] = Order::where('branch_id', $branch->id)
                ->where('status', 'completed')
                ->sum('total_amount');
        }

        $urgentAlerts = Product::whereHas('branches', function($query) use ($selectedBranchId) {
            if ($selectedBranchId) {
                $query->where('branch_id', $selectedBranchId);
            }
            $query->where('stock_quantity', '<', 10);
        })->with(['branches' => function($q) use ($selectedBranchId) {
            if ($selectedBranchId) {
                $q->where('branch_id', $selectedBranchId);
            }
        }])->get();

        return view('admin', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalProducts', 
            'urgentAlerts', 
            'branches',
            'branchRevenue',
            'selectedBranch'
        ));
    }
}
