<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->where('is_active', true)->get();

        return view('category', compact('category', 'products'));
    }

    public function subcategory($categorySlug, $subcategorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        // Filter by category AND subcategory slug
        $products = \App\Models\Product::where('category_id', $category->id)
            ->where('subcategory', $subcategorySlug)
            ->where('is_active', true)
            ->get();

        return view('category', compact('category', 'products', 'subcategorySlug'));
    }
}
