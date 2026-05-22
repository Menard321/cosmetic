@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.products.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Catalog
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Edit Product</h2>
    <p class="font-body-md text-on-surface-variant">Update the details for "{{ $product->name }}".</p>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="max-w-[800px]">
    @csrf
    @method('PUT')
    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 shadow-sm space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Product Name</label>
                <input type="text" name="name" class="form-input-premium w-full focus:ring-primary" value="{{ $product->name }}" required>
            </div>
            <div>
                <label class="label-premium block mb-2">Brand</label>
                <input type="text" name="brand" class="form-input-premium w-full" value="{{ $product->brand }}" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Category</label>
                <select name="category_id" class="form-input-premium w-full" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label-premium block mb-2">Price (TZS)</label>
                <input type="number" name="price" class="form-input-premium w-full" value="{{ intval($product->price) }}" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label-premium block mb-2">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-input-premium w-full" value="{{ $product->stock_quantity }}" required>
            </div>
            <div>
                <label class="label-premium block mb-2">Product Image (New Upload)</label>
                <input type="file" name="image" class="form-input-premium w-full p-2 text-xs" accept="image/*">
                <p class="text-[10px] text-on-surface-variant mt-1 italic">Leave blank to keep existing image.</p>
            </div>
        </div>

        @if($product->image_url)
            <div class="flex gap-4 items-center p-4 bg-surface-container-low rounded-lg border border-outline-variant/20">
                <img src="{{ $product->image_url }}" class="w-16 h-16 rounded object-cover">
                <p class="text-xs text-on-surface-variant font-bold uppercase tracking-widest italic">Current Preview</p>
            </div>
        @endif

        <div>
            <label class="label-premium block mb-2">Product Description</label>
            <textarea name="description" rows="4" class="form-input-premium w-full">{{ $product->description }}</textarea>
        </div>

        <div class="pt-6 border-t border-outline-variant/30 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3 rounded-xl font-label-md text-on-surface-variant hover:bg-surface-variant transition-colors border border-outline-variant">Cancel</a>
            <button type="submit" class="bg-primary text-white px-10 py-3 rounded-xl font-label-md hover:bg-secondary transition-all shadow-lg hover:translate-y-[-2px] active:translate-y-0">
                Update Product
            </button>
        </div>
    </div>
</form>
@endsection
