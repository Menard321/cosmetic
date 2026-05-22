<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Only get users with 'customer' role
        $query = User::role('customer');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->segment) {
            $query->where('customer_segment', $request->segment);
        }

        $customers = $query->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function($q) {
            $q->latest()->limit(5);
        }]);
        
        return view('admin.customers.show', compact('user'));
    }

    public function toggleBan(User $user)
    {
        $user->update(['is_banned' => !$user->is_banned]);
        $status = $user->is_banned ? 'banned' : 'unbanned';
        return back()->with('success', "Customer has been $status.");
    }

    public function updatePoints(Request $request, User $user)
    {
        $request->validate(['points' => 'required|integer']);
        $user->update(['loyalty_points' => $request->points]);
        return back()->with('success', 'Loyalty points updated.');
    }
}
