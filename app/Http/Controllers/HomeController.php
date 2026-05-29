<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $branchId = session('active_branch_id');
        $query = \App\Models\Product::where('is_trending', true)
            ->where('is_active', true);

        if ($branchId) {
            $query->whereHas('branches', function($q) use ($branchId) {
                $q->where('branch_id', $branchId)->where('stock_quantity', '>', 0);
            });
        } else {
             $query->where('stock_quantity', '>', 0);
        }

        $trendingProducts = $query->with('category')->get();
        return view('home', compact('trendingProducts'));
    }
}
