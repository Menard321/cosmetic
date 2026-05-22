<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $trendingProducts = \App\Models\Product::where('is_trending', true)
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->get();
        return view('home', compact('trendingProducts'));
    }
}
