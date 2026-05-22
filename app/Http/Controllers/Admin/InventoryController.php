<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InventoryBatch;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with(['batches', 'category'])->get();
        
        // Real-time calculation: out of stock products to auto-disable check
        // In a real app, this would be a scheduled task or event-driven, 
        // but for this demo, we'll showing the monitoring side.
        
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->get();
        $expiredBatches = InventoryBatch::with('product')
            ->where('expiry_date', '<', now())
            ->get();

        return view('admin.inventory.index', compact('products', 'lowStockProducts', 'expiredBatches'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('admin.inventory.suppliers', compact('suppliers'));
    }

    public function storeSupplier(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Supplier::create($request->all());
        return back()->with('success', 'Supplier added.');
    }

    public function restockForm(Product $product)
    {
        $suppliers = Supplier::all();
        return view('admin.inventory.restock', compact('product', 'suppliers'));
    }

    public function restock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'batch_number' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'reason' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request, $product) {
            // 1. Create Batch
            InventoryBatch::create([
                'product_id' => $product->id,
                'supplier_id' => $request->supplier_id,
                'batch_number' => $request->batch_number,
                'expiry_date' => $request->expiry_date,
                'initial_quantity' => $request->quantity,
                'current_quantity' => $request->quantity,
            ]);

            // 2. Update Product Stock
            $product->increment('stock_quantity', $request->quantity);
            
            // 3. Log History
            InventoryLog::create([
                'product_id' => $product->id,
                'type' => 'restock',
                'quantity' => $request->quantity,
                'reason' => $request->reason ?? 'Regular restock',
                'user_id' => auth()->id()
            ]);

            // 4. Auto-enable if it was disabled
            if ($product->stock_quantity > 0) {
                $product->update(['is_active' => true]);
            }
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Stock updated successfully.');
    }

    public function history()
    {
        $logs = InventoryLog::with(['product', 'user'])->latest()->paginate(20);
        return view('admin.inventory.history', compact('logs'));
    }
}
