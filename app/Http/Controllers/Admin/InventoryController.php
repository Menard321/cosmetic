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
        $productsQuery = Product::with(['batches', 'category']);
        $branchId = null;

        if (auth()->user()->hasRole('branch-manager')) {
            $branchId = auth()->user()->branch_id;
            // Only show products mapped to this branch
            $productsQuery->whereHas('branches', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $products = $productsQuery->get();
        
        $lowStockProducts = Product::where('stock_quantity', '<', 10);
        if ($branchId) {
            $lowStockProducts->whereHas('branches', function($q) use ($branchId) {
                $q->where('branch_id', $branchId)->where('branch_inventories.stock_quantity', '<', 10);
            });
        }
        $lowStockProducts = $lowStockProducts->get();

        $expiredBatches = InventoryBatch::with('product')
            ->where('expiry_date', '<', now())
            ->get();

        return view('admin.inventory.index', compact('products', 'lowStockProducts', 'expiredBatches', 'branchId'));
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
        $branches = \App\Models\Branch::all();
        return view('admin.inventory.restock', compact('product', 'suppliers', 'branches'));
    }

    public function restock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'branch_id' => 'required|exists:branches,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'batch_number' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'reason' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request, $product) {
            $user = auth()->user();
            $branchId = $request->branch_id;

            // 1. Create Batch
            InventoryBatch::create([
                'product_id' => $product->id,
                'supplier_id' => $request->supplier_id,
                'batch_number' => $request->batch_number,
                'expiry_date' => $request->expiry_date,
                'initial_quantity' => $request->quantity,
                'current_quantity' => $request->quantity,
            ]);

            // 2. Update Product Stock (Global)
            $product->increment('stock_quantity', $request->quantity);
            
            // 3. Update Branch Stock (Pivot)
            $pivot = $product->branches()->where('branch_id', $branchId)->first();
            if ($pivot) {
                $pivot->pivot->increment('stock_quantity', $request->quantity);
            } else {
                $product->branches()->attach($branchId, [
                    'stock_quantity' => $request->quantity,
                    'is_available' => true
                ]);
            }

            // 4. Log History
            InventoryLog::create([
                'product_id' => $product->id,
                'type' => 'restock',
                'quantity' => $request->quantity,
                'reason' => $request->reason ?? 'Regular restock',
                'user_id' => $user->id,
                'branch_id' => $branchId
            ]);

            // 5. Auto-enable if it was disabled
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
