<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();
        return view('customer.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('customer.order-show', compact('order'));
    }

    public function wishlist()
    {
        return view('customer.wishlist');
    }

    public function addresses()
    {
        return view('customer.addresses');
    }

    public function notifications()
    {
        return view('customer.notifications');
    }

    public function loyalty()
    {
        return view('customer.loyalty');
    }
}
