<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Branch;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Monthly Revenue Data (Mock for visualization)
        $monthlyRevenue = [
            'Jan' => Order::whereMonth('created_at', 1)->where('status', 'completed')->sum('total_amount'),
            'Feb' => Order::whereMonth('created_at', 2)->where('status', 'completed')->sum('total_amount'),
            'Mar' => Order::whereMonth('created_at', 3)->where('status', 'completed')->sum('total_amount'),
            'Apr' => Order::whereMonth('created_at', 4)->where('status', 'completed')->sum('total_amount'),
            'May' => Order::whereMonth('created_at', 5)->where('status', 'completed')->sum('total_amount'),
        ];

        // Top Selling Products
        $topProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Branch Performance
        $branches = Branch::withCount(['orders' => function($q) {
            $q->where('status', 'completed');
        }])->get();

        return view('admin.analytics.index', compact('monthlyRevenue', 'topProducts', 'branches'));
    }
}
