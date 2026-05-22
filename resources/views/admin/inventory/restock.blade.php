@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.inventory.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Inventory
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Replenish Stock</h2>
    <p class="font-body-md text-on-surface-variant">Update inventory for <strong>{{ $product->name }}</strong> by adding a new batch.</p>
</div>

<form action="{{ route('admin.inventory.restock.store', $product->id) }}" method="POST" class="max-w-[700px]">
    @csrf
    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 shadow-sm space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Restock Quantity</label>
                <input type="number" name="quantity" class="form-input-premium w-full" placeholder="Units to add" required min="1">
            </div>
            <div>
                <label class="label-premium block mb-2">Supplier</label>
                <select name="supplier_id" class="form-input-premium w-full">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Batch Number</label>
                <input type="text" name="batch_number" class="form-input-premium w-full" placeholder="e.g. TZ-2024-001">
            </div>
            <div>
                <label class="label-premium block mb-2">Expiry Date (Cosmetic Safety)</label>
                <input type="date" name="expiry_date" class="form-input-premium w-full" required>
            </div>
        </div>

        <div>
            <label class="label-premium block mb-2">Reason for Adjustment</label>
            <textarea name="reason" rows="3" class="form-input-premium w-full" placeholder="Regular restock, damaged return replacement, etc."></textarea>
        </div>

        <div class="pt-6 border-t border-outline-variant/30 flex justify-end gap-4">
            <button type="submit" class="bg-primary text-white px-10 py-3 rounded-xl font-label-md hover:bg-secondary transition-all shadow-lg">
                Confirm Restock
            </button>
        </div>
    </div>
</form>
@endsection
