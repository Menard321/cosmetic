<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class RiderController extends Controller
{
    public function index()
    {
        $availableOrders = Order::where('delivery_status', 'pending')->get();
        $myOrders = Order::where('rider_id', auth()->id())->get();

        return view('rider.dashboard', compact('availableOrders', 'myOrders'));
    }
}
