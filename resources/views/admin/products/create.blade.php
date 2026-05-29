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
                <input type="text" name="brand" class="form-input-premium w-full" placeholder="e.g. Angels Beauty" required>
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

        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="label-premium block mb-4 uppercase tracking-[0.2em] text-[10px] text-primary">Inventory per Branch</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($branches as $branch)
                        <div class="p-4 bg-surface-variant/30 border border-outline-variant/30 rounded-xl">
                            <label class="font-bold text-xs mb-2 block">{{ $branch->name }}</label>
                            <input type="number" name="branches[{{ $branch->id }}][stock]" class="form-input-premium w-full text-sm" value="0" min="0" required>
                            <p class="text-[9px] text-on-surface-variant mt-1">Starting Stock</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="label-premium block mb-2">Product Image (Upload File)</label>
                <div class="flex items-center gap-4 p-4 border-2 border-dashed border-outline-variant/50 rounded-2xl hover:border-primary transition-colors cursor-pointer group relative">
                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20">
                        <span class="material-symbols-outlined text-primary">upload_file</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Select a clear product shot</p>
                        <p class="text-[10px] text-on-surface-variant italic">Max 2MB (JPG, PNG, WEBP)</p>
                    </div>
                </div>
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
