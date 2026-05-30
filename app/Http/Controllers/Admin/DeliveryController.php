<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DeliveryController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->whereIn('status', ['pending', 'packed', 'shipped', 'delivered'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        // Stats for cards
        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.delivery', compact('orders', 'stats'));
    }
}
