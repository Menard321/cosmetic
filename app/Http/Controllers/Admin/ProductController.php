<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if it exists and is a local file
            if ($product->image_url && str_contains($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url && str_contains($product->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function bulkCreate()
    {
        $categories = Category::all();
        return view('admin.products.bulk', compact('categories'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.brand' => 'required|string|max:255',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.category_id' => 'required|exists:categories,id',
            'products.*.stock_quantity' => 'required|integer|min:0',
        ]);

        foreach ($request->products as $index => $productData) {
            if (isset($request->all()['products'][$index]['image'])) {
                $path = $request->file('products.'.$index.'.image')->store('products', 'public');
                $productData['image_url'] = '/storage/' . $path;
            }
            Product::create($productData);
        }

        return redirect()->route('admin.products.index')->with('success', count($request->products) . ' products added successfully!');
    }
}
