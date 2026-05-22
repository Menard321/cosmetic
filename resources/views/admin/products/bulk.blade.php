@extends('layouts.admin')

@section('content')
<div class="mb-stack-lg">
    <a href="{{ route('admin.products.index') }}" class="text-on-surface-variant hover:text-primary flex items-center gap-2 mb-4 text-sm font-bold">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Catalog
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface">Bulk Product Addition</h2>
    <p class="font-body-md text-on-surface-variant">Add multiple products to your showroom at once. Efficiency at its best.</p>
</div>

<form action="{{ route('admin.products.bulk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="glass-card p-8 rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="bulk-table">
                <thead class="text-on-surface-variant font-label-sm uppercase tracking-widest border-b border-outline-variant/30">
                    <tr>
                        <th class="px-4 py-4 min-w-[180px]">Product Name</th>
                        <th class="px-4 py-4 min-w-[120px]">Brand</th>
                        <th class="px-4 py-4 min-w-[120px]">Category</th>
                        <th class="px-4 py-4 min-w-[100px]">Price</th>
                        <th class="px-4 py-4 min-w-[150px]">Image</th>
                        <th class="px-4 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20" id="product-rows">
                    <!-- Initial Row -->
                    <tr class="product-row">
                        <td class="px-2 py-4">
                            <input type="text" name="products[0][name]" class="form-input-premium w-full text-sm" placeholder="Name" required>
                        </td>
                        <td class="px-2 py-4">
                            <input type="text" name="products[0][brand]" class="form-input-premium w-full text-sm" placeholder="Brand" required>
                        </td>
                        <td class="px-2 py-4">
                            <select name="products[0][category_id]" class="form-input-premium w-full text-sm" required>
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-2 py-4">
                            <input type="number" name="products[0][price]" class="form-input-premium w-full text-sm" placeholder="Price" required>
                        </td>
                        <td class="px-2 py-4">
                            <input type="file" name="products[0][image]" class="form-input-premium w-full text-xs" accept="image/*">
                        </td>
                        <td class="px-2 py-4 text-center">
                            <button type="button" class="text-error opacity-30 cursor-not-allowed" disabled>
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-between items-center border-t border-outline-variant/30 pt-6">
            <button type="button" id="add-row" class="text-primary font-label-md flex items-center gap-2 hover:underline">
                <span class="material-symbols-outlined text-sm">add_circle</span> Add another product row
            </button>
            <div class="flex gap-4">
                <a href="{{ route('admin.products.index') }}" class="px-8 py-3 rounded-xl font-label-md text-on-surface-variant hover:bg-surface-variant transition-colors border border-outline-variant">Cancel</a>
                <button type="submit" class="bg-on-background text-white px-10 py-3 rounded-xl font-label-md hover:bg-primary transition-all shadow-lg">
                    Add All Products
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    let rowCount = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const tbody = document.getElementById('product-rows');
        const newRow = document.createElement('tr');
        newRow.className = 'product-row hover:bg-surface-container-low/30 transition-colors';
        newRow.innerHTML = `
            <td class="px-2 py-4">
                <input type="text" name="products[${rowCount}][name]" class="form-input-premium w-full text-sm" placeholder="Name" required>
            </td>
            <td class="px-2 py-4">
                <input type="text" name="products[${rowCount}][brand]" class="form-input-premium w-full text-sm" placeholder="Brand" required>
            </td>
            <td class="px-2 py-4">
                <select name="products[${rowCount}][category_id]" class="form-input-premium w-full text-sm" required>
                    <option value="">Select</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="px-2 py-4">
                <input type="number" name="products[${rowCount}][price]" class="form-input-premium w-full text-sm" placeholder="Price" required>
            </td>
            <td class="px-2 py-4">
                <input type="file" name="products[${rowCount}][image]" class="form-input-premium w-full text-xs" accept="image/*">
            </td>
            <td class="px-2 py-4 text-center">
                <button type="button" class="remove-row text-error hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-xl">delete</span>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
        rowCount++;

        // Add event listener to new remove button
        newRow.querySelector('.remove-row').addEventListener('click', function() {
            newRow.remove();
        });
    });
</script>
@endsection
