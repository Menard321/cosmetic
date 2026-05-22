<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::sum('total_amount');
        $totalOrders = Order::count();
        $activeVendors = 48; // Static for now as we don't have Vendor model

        $urgentAlerts = Product::where('stock_quantity', '<', 10)->get();

        return view('admin', compact('totalRevenue', 'totalOrders', 'activeVendors', 'urgentAlerts'));
    }
}
