@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.products.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Catalog
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Add New Product</h2>
    <p class="font-body-md text-on-surface-variant">Fill in the details to launch a new product to the showroom.</p>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[800px]">
    @csrf
    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 shadow-sm space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Product Name</label>
                <input type="text" name="name" class="form-input-premium w-full focus:ring-primary" placeholder="e.g. Silk Glow Serum" required>
            </div>
            <div>
                <label class="label-premium block mb-2">Brand</label>
                <input type="text" name="brand" class="form-input-premium w-full" placeholder="e.g. Lulu Beauty" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Category</label>
                <select name="category_id" class="form-input-premium w-full" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label-premium block mb-2">Price (TZS)</label>
                <input type="number" name="price" class="form-input-premium w-full" placeholder="85000" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-input-premium w-full" value="50" required>
            </div>
            <div>
                <label class="label-premium block mb-2">Product Image (Upload File)</label>
                <input type="file" name="image" class="form-input-premium w-full p-2 text-xs" accept="image/*">
                <p class="text-[10px] text-on-surface-variant mt-1 italic">Select a clear product shot from your computer (Max 2MB).</p>
            </div>
        </div>

        <div>
            <label class="label-premium block mb-2">Product Description</label>
            <textarea name="description" rows="4" class="form-input-premium w-full" placeholder="Describe the luxury and benefits of this product..."></textarea>
        </div>

        <div class="pt-6 border-t border-outline-variant/30 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3 rounded-xl font-label-md text-on-surface-variant hover:bg-surface-variant transition-colors border border-outline-variant">Cancel</a>
            <button type="submit" class="bg-primary text-white px-10 py-3 rounded-xl font-label-md hover:bg-secondary transition-all shadow-lg hover:translate-y-[-2px] active:translate-y-0">
                Publish Product
            </button>
        </div>
    </div>
</form>
@endsection
