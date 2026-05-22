<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function orders()
    {
        return view('customer.orders');
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
