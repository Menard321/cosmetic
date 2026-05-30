<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Branch-Manager Restricted View
        if (auth()->user()->hasRole('branch-manager')) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        // Filtering
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->customer) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%');
            });
        }
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (auth()->user()->hasRole('branch-manager') && $order->branch_id !== auth()->user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['items.product', 'user', 'rider']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded'
        ]);

        $order->update(['status' => $request->status]);

        // If it's a delivery status update
        if (in_array($request->status, ['shipped', 'delivered'])) {
            $order->update(['delivery_status' => $request->status]);
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    public function invoice(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.invoice', compact('order'));
    }
}
